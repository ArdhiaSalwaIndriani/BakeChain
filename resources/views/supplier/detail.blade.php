 @extends('supplier.layout')

@section('title', 'Detail Pembelian')
@section('heading', 'Detail Pembelian')
@section('subtitle', 'Kelola pemenuhan pesanan, status pengiriman, dan informasi batch bahan baku.')

@section('content')
@php
    $urutan = [
        'direncanakan',
        'diproses',
        'dikirim',
        'diterima',
    ];

    $posisi = array_search($pembelian->status, $urutan, true);

    $opsiStatus = [
        'direncanakan' => [
            'diproses' => 'Diproses',
        ],
        'diproses' => [
            'dikirim' => 'Dikirim',
        ],
    ];

    $statusTersedia = $opsiStatus[$pembelian->status] ?? [];
    $punyaBatch = $batches->isNotEmpty();
@endphp

<style>
    .detail-banner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 22px;
        padding: 24px;
        border: 1px solid #e6e9ef;
        border-radius: 20px;
        background: linear-gradient(135deg, #ffffff, #fff5f5);
    }

    .detail-banner h2 {
        margin-bottom: 5px;
        color: #202938;
        font-size: 21px;
    }

    .detail-banner p {
        color: #667085;
        font-size: 13px;
    }

    .detail-code {
        display: inline-block;
        margin-bottom: 8px;
        color: #a91d2a;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .detail-status {
        flex-shrink: 0;
    }

    .steps {
        display: flex;
        gap: 8px;
        margin-bottom: 22px;
    }

    .step {
        flex: 1;
        padding: 13px 8px;
        border: 1px solid #e6e9ef;
        border-radius: 12px;
        background: #fff;
        color: #98a2b3;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }

    .step.done {
        border-color: #b7e2c1;
        background: #ecfdf3;
        color: #067647;
    }

    .step.now {
        border-color: #e5aab0;
        background: #fff1f2;
        color: #a91d2a;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(300px, 0.85fr);
        gap: 20px;
        align-items: start;
    }

    .detail-panel {
        min-width: 0;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e6e9ef;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 20px #18223007;
    }

    .detail-panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .detail-panel-heading h3 {
        color: #202938;
        font-size: 17px;
    }

    .detail-description {
        margin-bottom: 18px;
        color: #667085;
        font-size: 13px;
    }

    .detail-kv {
        display: grid;
        grid-template-columns: minmax(115px, 0.8fr) minmax(0, 1.2fr);
        gap: 0;
    }

    .detail-kv dt,
    .detail-kv dd {
        padding: 13px 0;
        border-bottom: 1px solid #edf0f4;
        font-size: 13px;
    }

    .detail-kv dt {
        padding-right: 12px;
        color: #667085;
    }

    .detail-kv dd {
        overflow-wrap: anywhere;
        color: #202938;
        font-weight: 600;
    }

    .status-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .status-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .status-field label {
        color: #344054;
        font-size: 13px;
        font-weight: 700;
    }

    .status-field select,
    .status-field input {
        width: 100%;
        min-height: 46px;
        padding: 11px 13px;
        border: 1px solid #d0d5dd;
        border-radius: 12px;
        background: #fff;
        color: #202938;
        font: inherit;
    }

    .status-field select:focus,
    .status-field input:focus {
        outline: 3px solid #a91d2a18;
        border-color: #a91d2a;
    }

    .status-help {
        color: #667085;
        font-size: 12px;
        line-height: 1.7;
    }

    .status-notice {
        padding: 14px;
        border: 1px solid #e6e9ef;
        border-radius: 14px;
        background: #f8f9fb;
        color: #475467;
        font-size: 13px;
        line-height: 1.7;
    }

    .status-notice.success {
        border-color: #b7e2c1;
        background: #ecfdf3;
        color: #067647;
    }

    .status-notice.warning {
        border-color: #f5d69a;
        background: #fffaeb;
        color: #93370d;
    }

    .status-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .status-actions .btn {
        min-height: 44px;
        padding: 11px 16px;
        border-radius: 12px;
        font-weight: 700;
    }

    .batch-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .batch-summary-item {
        padding: 16px;
        border: 1px solid #e6e9ef;
        border-radius: 14px;
        background: #f8f9fb;
    }

    .batch-summary-item span {
        display: block;
        margin-bottom: 6px;
        color: #667085;
        font-size: 12px;
    }

    .batch-summary-item strong {
        color: #202938;
        font-size: 19px;
    }

    .batch-form {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        align-items: end;
    }

    .batch-form .field input {
        width: 100%;
        min-width: 0;
        min-height: 44px;
        border-radius: 12px;
    }

    .batch-form .btn {
        min-height: 44px;
        border-radius: 12px;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 2px 0 24px;
        padding: 11px 15px;
        border: 1px solid #e6e9ef;
        border-radius: 12px;
        background: #fff;
        color: #344054;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .detail-back:hover {
        border-color: #a91d2a;
        color: #a91d2a;
    }

    @media (max-width: 1000px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .batch-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .detail-banner {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
        }

        .steps {
            flex-direction: column;
        }

        .detail-panel {
            padding: 18px;
        }

        .detail-kv {
            grid-template-columns: 1fr;
        }

        .detail-kv dt {
            padding-bottom: 3px;
            border-bottom: 0;
        }

        .detail-kv dd {
            padding-top: 3px;
        }

        .batch-form {
            grid-template-columns: 1fr;
        }

        .batch-summary {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="detail-banner">
    <div>
        <span class="detail-code">{{ $pembelian->kode_pembelian }}</span>
        <h2>Detail Permintaan Bahan</h2>
        <p>
            Periksa informasi pesanan dan perbarui status pemenuhan
            sesuai progres pengiriman.
        </p>
    </div>

    <span class="badge st-{{ \Illuminate\Support\Str::slug($pembelian->status) }} detail-status">
        {{ ucfirst($pembelian->status) }}
    </span>
</div>

@if ($pembelian->status !== 'dibatalkan')
    <div class="steps">
        @foreach ($urutan as $i => $langkah)
            <div class="step {{ $posisi !== false && $i < $posisi ? 'done' : '' }} {{ $i === $posisi ? 'now' : '' }}">
                {{ ucfirst($langkah) }}
            </div>
        @endforeach
    </div>
@endif

<div class="detail-grid">
    <div class="detail-panel">
        <div class="detail-panel-heading">
            <h3>Informasi Pesanan</h3>
        </div>

        <dl class="detail-kv">
            <dt>Kode Pembelian</dt>
            <dd>{{ $pembelian->kode_pembelian }}</dd>

            <dt>Jenis Bahan</dt>
            <dd>{{ $pembelian->nama_bahan }}</dd>

            <dt>Jumlah Dipesan</dt>
            <dd>{{ (float) $pembelian->jumlah }} {{ $pembelian->satuan }}</dd>

            <dt>Harga per Unit</dt>
            <dd>
                {{ $pembelian->harga_per_unit !== null
                    ? 'Rp ' . number_format((float) $pembelian->harga_per_unit, 0, ',', '.')
                    : '-' }}
            </dd>

            <dt>Estimasi Total</dt>
            <dd>
                {{ $pembelian->total_estimasi !== null
                    ? 'Rp ' . number_format((float) $pembelian->total_estimasi, 0, ',', '.')
                    : ($pembelian->harga_per_unit !== null
                        ? 'Rp ' . number_format((float) $pembelian->harga_per_unit * (float) $pembelian->jumlah, 0, ',', '.')
                        : '-') }}
            </dd>

            <dt>Tanggal Pembelian</dt>
            <dd>{{ \Carbon\Carbon::parse($pembelian->tanggal_pesan)->locale('id')->translatedFormat('j F Y') }}</dd>

            <dt>Estimasi Kirim</dt>
            <dd>
                {{ $pembelian->tanggal_estimasi_kirim
                    ? \Carbon\Carbon::parse($pembelian->tanggal_estimasi_kirim)->locale('id')->translatedFormat('j F Y')
                    : '-' }}
            </dd>

            <dt>Catatan Bakery</dt>
            <dd>{{ $pembelian->catatan ?: '-' }}</dd>

            <dt>Waktu Diproses</dt>
            <dd>
                {{ $pembelian->diproses_at
                    ? \Carbon\Carbon::parse($pembelian->diproses_at)->locale('id')->translatedFormat('j F Y H:i')
                    : '-' }}
            </dd>

            <dt>Waktu Dikirim</dt>
            <dd>
                {{ $pembelian->dikirim_at
                    ? \Carbon\Carbon::parse($pembelian->dikirim_at)->locale('id')->translatedFormat('j F Y H:i')
                    : '-' }}
            </dd>

            <dt>Waktu Diterima</dt>
            <dd>
                {{ $pembelian->diterima_at
                    ? \Carbon\Carbon::parse($pembelian->diterima_at)->locale('id')->translatedFormat('j F Y H:i')
                    : '-' }}
            </dd>

            <dt>Catatan Pengiriman</dt>
            <dd>{{ $pembelian->catatan_pengiriman ?: '-' }}</dd>
        </dl>
    </div>

    <div class="detail-panel">
        <div class="detail-panel-heading">
            <h3>Update Status</h3>
        </div>

        @if ($statusTersedia)
            <p class="detail-description">
                Pilih status sesuai kondisi pemenuhan pesanan saat ini.
            </p>

            @if ($pembelian->status === 'diproses')
                <div class="status-notice {{ $punyaBatch ? 'success' : 'warning' }}">
                    <strong>
                        {{ $punyaBatch ? 'Batch sudah tercatat' : 'Batch belum tercatat' }}
                    </strong>

                    <p>
                        {{ $punyaBatch
                            ? 'Pastikan data batch sudah benar sebelum mengubah status menjadi Dikirim.'
                            : 'Tambahkan informasi batch bahan terlebih dahulu. Status pengiriman belum dapat diperbarui sebelum batch dicatat.' }}
                    </p>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('supplier.permintaan.status', $pembelian->id) }}"
                class="status-form"
            >
                @csrf
                @method('PATCH')

                <div class="status-field">
                    <label for="status">Status Pesanan</label>

                    <select id="status" name="status" required>
                        <option value="">Pilih status berikutnya</option>

                        @foreach ($statusTersedia as $nilai => $label)
                            <option
                                value="{{ $nilai }}"
                                @selected(old('status') === $nilai)
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <p class="status-help">
                        Status hanya dapat dilanjutkan mengikuti alur pesanan
                        agar progres tetap tercatat dengan benar.
                    </p>
                </div>

                @if ($pembelian->status === 'diproses')
                    <div class="status-field">
                        <label for="catatan_pengiriman">
                            Catatan Pengiriman
                        </label>

                        <input
                            type="text"
                            id="catatan_pengiriman"
                            name="catatan_pengiriman"
                            maxlength="255"
                            value="{{ old('catatan_pengiriman') }}"
                            placeholder="Contoh: nama kurir atau nomor resi"
                        >
                    </div>
                @endif

                <div class="status-actions">
                    <button
                        type="submit"
                        class="btn"
                        @disabled($pembelian->status === 'diproses' && ! $punyaBatch)
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        @elseif ($pembelian->status === 'dikirim')
            <div class="status-notice">
                <strong>Pesanan sedang dikirim</strong>
                <p>
                    Tunggu Pemilik UMKM mengonfirmasi bahwa bahan sudah
                    diterima. Status Diterima bukan kewenangan Supplier.
                </p>
            </div>

        @elseif ($pembelian->status === 'diterima')
            <div class="status-notice success">
                <strong>Pesanan telah diterima</strong>
                <p>
                    Pemilik UMKM telah mengonfirmasi penerimaan bahan.
                    Tidak ada tindakan lanjutan yang diperlukan.
                </p>
            </div>

        @elseif ($pembelian->status === 'dibatalkan')
            <div class="status-notice warning">
                <strong>Pesanan dibatalkan</strong>
                <p>
                    Pesanan ini telah dibatalkan dan tidak dapat diproses
                    atau dikirim melalui halaman ini.
                </p>
            </div>
        @endif
    </div>
</div>

<div class="detail-panel">
    <div class="detail-panel-heading">
        <h3>Informasi Batch</h3>
    </div>

    <div class="batch-summary">
        <div class="batch-summary-item">
            <span>Jumlah Batch</span>
            <strong>{{ $batches->count() }}</strong>
        </div>

        <div class="batch-summary-item">
            <span>Jumlah Tercatat</span>
            <strong>{{ $jumlahBatch }} {{ $pembelian->satuan }}</strong>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode Batch</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                    <th>Kedaluwarsa</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($batches as $batch)
                    <tr>
                        <td>
                            <strong>{{ $batch->kode_batch }}</strong>
                        </td>

                        <td>
                            {{ (float) $batch->jumlah }} {{ $pembelian->satuan }}
                        </td>

                        <td>
                            {{ $batch->tanggal_masuk
                                ? \Carbon\Carbon::parse($batch->tanggal_masuk)->locale('id')->translatedFormat('j F Y')
                                : '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->locale('id')->translatedFormat('j F Y') }}
                        </td>

                        <td>
                            <span class="badge st-{{ \Illuminate\Support\Str::slug($batch->status) }}">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada batch untuk pesanan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($bisaInputBatch)
        <hr style="border: 0; border-top: 1px solid #edf0f4; margin: 22px 0">

        <h3 style="margin-bottom: 8px; color: #202938; font-size: 16px;">
            Tambah Batch Bahan
        </h3>

        <p class="detail-description">
            Catat kode batch, jumlah bahan, dan tanggal kedaluwarsa.
            Jumlah batch tidak boleh melebihi jumlah pesanan.
        </p>

        <p class="status-help" style="margin-bottom: 18px;">
            Sisa jumlah yang belum dicatat:
            <strong>{{ $sisaBatch }} {{ $pembelian->satuan }}</strong>
        </p>

        @if ($sisaBatch > 0)
            <form
                method="POST"
                action="{{ route('supplier.permintaan.batch', $pembelian->id) }}"
                class="batch-form"
            >
                @csrf

                <div class="field">
                    <label for="kode_batch">Kode Batch</label>

                    <input
                        type="text"
                        id="kode_batch"
                        name="kode_batch"
                        maxlength="100"
                        value="{{ old('kode_batch') }}"
                        placeholder="Contoh: BATCH-001"
                        required
                    >
                </div>

                <div class="field">
                    <label for="jumlah">Jumlah ({{ $pembelian->satuan }})</label>

                    <input
                        type="number"
                        id="jumlah"
                        name="jumlah"
                        step="0.01"
                        min="0.01"
                        max="{{ min(999999, $sisaBatch) }}"
                        value="{{ old('jumlah') }}"
                        placeholder="Masukkan jumlah"
                        required
                    >
                </div>

                <div class="field">
                    <label for="tanggal_kadaluarsa">Tanggal Kedaluwarsa</label>

                    <input
                        type="date"
                        id="tanggal_kadaluarsa"
                        name="tanggal_kadaluarsa"
                        min="{{ now()->addDay()->toDateString() }}"
                        value="{{ old('tanggal_kadaluarsa') }}"
                        required
                    >
                </div>

                <button type="submit" class="btn">
                    Tambah Batch
                </button>
            </form>
        @else
            <div class="status-notice success">
                Seluruh jumlah pesanan sudah tercatat dalam batch.
            </div>
        @endif
    @endif
</div>

<a
    href="{{ route('supplier.permintaan') }}"
    class="detail-back"
>
    ← Kembali ke Permintaan
</a>
@endsection