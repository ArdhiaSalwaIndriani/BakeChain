<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\BatchBahan;
use App\Models\PembelianBahan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $supplier = $request->user()->supplier;

        abort_if($supplier === null, 403, 'Akun supplier belum terhubung dengan data pemasok.');

        $perStatus = PembelianBahan::query()
            ->where('supplier_id', $supplier->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statistik = [
            'total' => (int) $perStatus->sum(),
            'menunggu' => (int) $perStatus->get(PembelianBahan::STATUS_DIRENCANAKAN, 0),
            'dikirim' => (int) $perStatus->get(PembelianBahan::STATUS_DIKIRIM, 0),
            'selesai' => (int) $perStatus->get(PembelianBahan::STATUS_DITERIMA, 0),
        ];

        $permintaanTerbaru = PembelianBahan::query()
            ->with('bahanBaku')
            ->where('supplier_id', $supplier->id)
            ->latest('tanggal_pesan')
            ->latest('id')
            ->limit(5)
            ->get();

        $batchTerbaru = BatchBahan::query()
            ->with('bahanBaku')
            ->where('supplier_id', $supplier->id)
            ->latest('tanggal_masuk')
            ->latest('id')
            ->limit(5)
            ->get();

        $jumlahBahan = BatchBahan::query()
            ->where('supplier_id', $supplier->id)
            ->distinct()
            ->count('bahan_baku_id');

        $labelStatus = [
            PembelianBahan::STATUS_DIRENCANAKAN => 'Menunggu Konfirmasi',
            PembelianBahan::STATUS_DIKONFIRMASI => 'Dikonfirmasi',
            PembelianBahan::STATUS_DIKIRIM => 'Dalam Pengiriman',
            PembelianBahan::STATUS_DITERIMA => 'Diterima',
            PembelianBahan::STATUS_DITOLAK => 'Ditolak',
        ];

        return view('supplier.dashboard', [
            'supplier' => $supplier,
            'statistik' => $statistik,
            'permintaanTerbaru' => $permintaanTerbaru,
            'batchTerbaru' => $batchTerbaru,
            'jumlahBahan' => $jumlahBahan,
            'labelStatus' => $labelStatus,
        ]);
    }
}