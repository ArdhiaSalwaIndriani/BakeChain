<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupplierController extends Controller
{
    private const STATUS_DIRENCANAKAN = 'direncanakan';
    private const STATUS_DIPROSES = 'diproses';
    private const STATUS_DIKIRIM = 'dikirim';
    private const STATUS_DITERIMA = 'diterima';
    private const STATUS_DIBATALKAN = 'dibatalkan';

    private const STATUSES = [
        self::STATUS_DIRENCANAKAN,
        self::STATUS_DIPROSES,
        self::STATUS_DIKIRIM,
        self::STATUS_DITERIMA,
        self::STATUS_DIBATALKAN,
    ];

    private const NEXT_STATUS = [
        self::STATUS_DIRENCANAKAN => self::STATUS_DIPROSES,
        self::STATUS_DIPROSES => self::STATUS_DIKIRIM,
    ];

    public function dashboard(): View
    {
        $supplier = $this->currentSupplier();
        $counts = array_fill_keys(self::STATUSES, 0);
        $terbaru = collect();
        $batchHampirKadaluarsa = 0;

        if ($supplier) {
            $counts = array_merge(
                $counts,
                DB::table('pembelian_bahan')
                    ->where('supplier_id', $supplier->id)
                    ->selectRaw('status, COUNT(*) as total')
                    ->groupBy('status')
                    ->pluck('total', 'status')
                    ->map(fn ($total) => (int) $total)
                    ->all()
            );

            $terbaru = $this->purchaseQuery($supplier->id)
                ->orderByDesc('p.created_at')
                ->limit(5)
                ->get();

            $batchHampirKadaluarsa = DB::table('batch_bahan')
                ->where('supplier_id', $supplier->id)
                ->whereBetween('tanggal_kadaluarsa', [
                    Carbon::today()->toDateString(),
                    Carbon::today()->addDays(30)->toDateString(),
                ])
                ->count();
        }

        return view('supplier.dashboard', [
            'supplier' => $supplier,
            'counts' => $counts,
            'totalPermintaan' => array_sum($counts),
            'perluDitindaklanjuti' => $counts[self::STATUS_DIRENCANAKAN] + $counts[self::STATUS_DIPROSES],
            'terbaru' => $terbaru,
            'batchHampirKadaluarsa' => $batchHampirKadaluarsa,
        ]);
    }

    public function profil(): View
    {
        $supplier = $this->currentSupplier();

        $ringkasan = [
            'total_pembelian' => 0,
            'total_pengiriman' => 0,
            'total_batch' => 0,
        ];

        if ($supplier) {
            $ringkasan = [
                'total_pembelian' => DB::table('pembelian_bahan')
                    ->where('supplier_id', $supplier->id)
                    ->count(),
                'total_pengiriman' => DB::table('pembelian_bahan')
                    ->where('supplier_id', $supplier->id)
                    ->whereIn('status', [self::STATUS_DIKIRIM, self::STATUS_DITERIMA])
                    ->count(),
                'total_batch' => DB::table('batch_bahan')
                    ->where('supplier_id', $supplier->id)
                    ->count(),
            ];
        }

        return view('supplier.profil', [
            'user' => Auth::user(),
            'supplier' => $supplier,
            'ringkasan' => $ringkasan,
        ]);
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nama_supplier' => ['required', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama akun wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'profile_photo.image' => 'File foto harus berupa gambar.',
            'profile_photo.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'profile_photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoLama = $user->profile_photo_path ?? null;
        $fotoBaru = null;

        if ($request->hasFile('profile_photo')) {
            $fotoBaru = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        try {
            DB::transaction(function () use ($user, $supplier, $data, $fotoBaru) {
                $updateUser = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'updated_at' => now(),
                ];

                if (Schema::hasColumn('users', 'profile_photo_path')) {
                    $updateUser['profile_photo_path'] = $fotoBaru ?? $user->profile_photo_path;
                }

                DB::table('users')
                    ->where('id', $user->id)
                    ->update($updateUser);

                DB::table('suppliers')
                    ->where('id', $supplier->id)
                    ->update([
                        'nama_supplier' => $data['nama_supplier'],
                        'kontak' => $data['kontak'] ?? null,
                        'alamat' => $data['alamat'] ?? null,
                        'updated_at' => now(),
                    ]);
            });
        } catch (\Throwable $exception) {
            if ($fotoBaru) {
                Storage::disk('public')->delete($fotoBaru);
            }

            throw $exception;
        }

        if ($fotoBaru && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('supplier.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function permintaan(Request $request): View|RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $request->validate([
            'status' => ['nullable', Rule::in(self::STATUSES)],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $query = $this->purchaseQuery($supplier->id);

        if ($request->filled('status')) {
            $query->where('p.status', $request->query('status'));
        }

        if ($request->filled('q')) {
            $keyword = '%'.$request->query('q').'%';

            $query->where(function ($sub) use ($keyword) {
                $sub->where('p.kode_pembelian', 'like', $keyword)
                    ->orWhere('b.nama_bahan', 'like', $keyword);
            });
        }

        return view('supplier.permintaan', [
            'supplier' => $supplier,
            'permintaan' => $query->orderByDesc('p.created_at')->paginate(10)->withQueryString(),
            'statuses' => self::STATUSES,
            'statusAktif' => $request->query('status'),
            'keyword' => $request->query('q'),
        ]);
    }

    public function show(int $id): View|RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $pembelian = $this->findPurchase($supplier->id, $id);

        $batches = DB::table('batch_bahan')
            ->where('pembelian_bahan_id', $pembelian->id)
            ->orderBy('tanggal_kadaluarsa')
            ->get();

        $jumlahBatch = (float) $batches->sum('jumlah');

        return view('supplier.detail', [
            'supplier' => $supplier,
            'pembelian' => $pembelian,
            'batches' => $batches,
            'jumlahBatch' => $jumlahBatch,
            'sisaBatch' => max(0, (float) $pembelian->jumlah - $jumlahBatch),
            'statusBerikutnya' => self::NEXT_STATUS[$pembelian->status] ?? null,
            'bisaInputBatch' => $pembelian->status === self::STATUS_DIPROSES,
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $data = $request->validate([
            'status' => ['required', Rule::in([self::STATUS_DIPROSES, self::STATUS_DIKIRIM])],
            'catatan_pengiriman' => ['nullable', 'string', 'max:255'],
        ]);

        $pembelian = $this->findPurchase($supplier->id, $id);
        $berikutnya = self::NEXT_STATUS[$pembelian->status] ?? null;

        if ($berikutnya === null || $berikutnya !== $data['status']) {
            return back()->withErrors([
                'status' => 'Status "'.ucfirst($pembelian->status).'" tidak dapat diubah menjadi "'.ucfirst($data['status']).'".',
            ]);
        }

        if ($berikutnya === self::STATUS_DIKIRIM) {
            $adaBatch = DB::table('batch_bahan')
                ->where('pembelian_bahan_id', $pembelian->id)
                ->exists();

            if (! $adaBatch) {
                return back()->withErrors([
                    'status' => 'Isi informasi batch bahan terlebih dahulu sebelum menandai pesanan sebagai dikirim.',
                ]);
            }
        }

        DB::transaction(function () use ($pembelian, $berikutnya, $data) {
            $now = now();

            if ($berikutnya === self::STATUS_DIPROSES) {
                DB::table('pembelian_bahan')
                    ->where('id', $pembelian->id)
                    ->update([
                        'status' => self::STATUS_DIPROSES,
                        'diproses_at' => $now,
                        'updated_at' => $now,
                    ]);

                return;
            }

            DB::table('pembelian_bahan')
                ->where('id', $pembelian->id)
                ->update([
                    'status' => self::STATUS_DIKIRIM,
                    'dikirim_at' => $now,
                    'catatan_pengiriman' => $data['catatan_pengiriman'] ?? null,
                    'updated_at' => $now,
                ]);

            DB::table('batch_bahan')
                ->where('pembelian_bahan_id', $pembelian->id)
                ->update([
                    'status' => self::STATUS_DIKIRIM,
                    'updated_at' => $now,
                ]);
        });

        return redirect()
            ->route('supplier.permintaan.show', $pembelian->id)
            ->with('success', 'Status pesanan berhasil diperbarui menjadi '.ucfirst($berikutnya).'.');
    }

    public function storeBatch(Request $request, int $id): RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $pembelian = $this->findPurchase($supplier->id, $id);

        if ($pembelian->status !== self::STATUS_DIPROSES) {
            return back()->withErrors([
                'kode_batch' => 'Batch hanya dapat ditambahkan saat pesanan berstatus diproses.',
            ]);
        }

        $data = $request->validate([
            'kode_batch' => [
                'required',
                'string',
                'max:100',
                Rule::unique('batch_bahan', 'kode_batch')->where('supplier_id', $supplier->id),
            ],
            'jumlah' => ['required', 'numeric', 'gt:0', 'max:999999'],
            'tanggal_kadaluarsa' => ['required', 'date', 'after:today'],
        ]);

        $sudahDibatch = (float) DB::table('batch_bahan')
            ->where('pembelian_bahan_id', $pembelian->id)
            ->sum('jumlah');

        if ($sudahDibatch + (float) $data['jumlah'] > (float) $pembelian->jumlah) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => 'Total jumlah batch melebihi jumlah pesanan ('.
                        rtrim(rtrim(number_format((float) $pembelian->jumlah, 2, '.', ''), '0'), '.').
                        ' '.$pembelian->satuan.').',
                ]);
        }

        DB::table('batch_bahan')->insert([
            'bahan_baku_id' => $pembelian->bahan_baku_id,
            'supplier_id' => $supplier->id,
            'pembelian_bahan_id' => $pembelian->id,
            'kode_batch' => $data['kode_batch'],
            'jumlah' => $data['jumlah'],
            'tanggal_masuk' => null,
            'tanggal_kadaluarsa' => $data['tanggal_kadaluarsa'],
            'status' => 'disiapkan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('supplier.permintaan.show', $pembelian->id)
            ->with('success', 'Batch bahan berhasil ditambahkan.');
    }

    public function riwayat(Request $request): View|RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $query = $this->purchaseQuery($supplier->id)
            ->whereIn('p.status', [self::STATUS_DIKIRIM, self::STATUS_DITERIMA]);

        if ($request->filled('dari')) {
            $query->whereDate('p.dikirim_at', '>=', $request->query('dari'));
        }

        if ($request->filled('sampai')) {
            $query->whereDate('p.dikirim_at', '<=', $request->query('sampai'));
        }

        return view('supplier.riwayat', [
            'supplier' => $supplier,
            'pengiriman' => $query->orderByDesc('p.dikirim_at')->paginate(10)->withQueryString(),
            'dari' => $request->query('dari'),
            'sampai' => $request->query('sampai'),
        ]);
    }

    public function batch(Request $request): View|RedirectResponse
    {
        $supplier = $this->currentSupplier();

        if (! $supplier) {
            return $this->redirectUnlinked();
        }

        $request->validate([
            'status' => ['nullable', Rule::in(['disiapkan', 'dikirim', 'tersedia', 'habis', 'kadaluarsa'])],
        ]);

        $query = DB::table('batch_bahan as bt')
            ->join('bahan_baku as b', 'b.id', '=', 'bt.bahan_baku_id')
            ->leftJoin('pembelian_bahan as p', 'p.id', '=', 'bt.pembelian_bahan_id')
            ->where('bt.supplier_id', $supplier->id)
            ->select('bt.*', 'b.nama_bahan', 'b.satuan', 'p.kode_pembelian');

        if ($request->filled('status')) {
            $query->where('bt.status', $request->query('status'));
        }

        return view('supplier.batch', [
            'supplier' => $supplier,
            'batches' => $query->orderBy('bt.tanggal_kadaluarsa')->paginate(10)->withQueryString(),
            'statusAktif' => $request->query('status'),
            'batasPeringatan' => Carbon::today()->addDays(30)->toDateString(),
        ]);
    }

    private function currentSupplier(): ?object
    {
        return DB::table('suppliers')
            ->where('user_id', Auth::id())
            ->first();
    }

    private function purchaseQuery(int $supplierId)
    {
        return DB::table('pembelian_bahan as p')
            ->join('bahan_baku as b', 'b.id', '=', 'p.bahan_baku_id')
            ->where('p.supplier_id', $supplierId)
            ->select('p.*', 'b.nama_bahan', 'b.satuan');
    }

    private function findPurchase(int $supplierId, int $id): object
    {
        $pembelian = $this->purchaseQuery($supplierId)
            ->where('p.id', $id)
            ->first();

        abort_unless($pembelian, 404);

        return $pembelian;
    }

    private function redirectUnlinked(): RedirectResponse
    {
        return redirect()
            ->route('supplier.dashboard')
            ->withErrors([
                'supplier' => 'Akun kamu belum ditautkan ke data supplier. Hubungi Admin atau Pemilik UMKM.',
            ]);
    }
}