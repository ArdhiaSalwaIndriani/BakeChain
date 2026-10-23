@extends('pemilik.layout')

@section('title', 'Penerimaan Bahan')
@section('heading', 'Penerimaan Bahan')
@section('subtitle', 'Catat bahan yang diterima dari rencana pembelian.')

@section('content')
<style>
.receiving-page {
    color:#302727;
}
.receiving-intro {
    margin-bottom:20px;
    color:#756b6b;
    font-size:12px;
}
.receiving-section-title {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin:22px 0 10px;
}
.receiving-section-title h2 {
    font-size:14px;
    color:#8C0000;
}
.receiving-section-title span {
    font-size:10px;
    color:#756b6b;
}
.receiving-queue {
    display:grid;
    grid-template-columns:minmax(0,1fr);
    border-top:1px solid #efdada;
    border-left:1px solid #efdada;
    background:#fff;
}
.receiving-queue-item {
    padding:12px 17px;
    border-right:1px solid #efdada;
    border-bottom:1px solid #efdada;
}
.receiving-queue-top {
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:12px;
}
.receiving-queue-top strong {
    font-size:12px;
    color:#302727;
}
.receiving-queue-top span {
    color:#756b6b;
    font-size:10px;
    white-space:nowrap;
}
.receiving-queue-meta {
    margin-top:5px;
    color:#756b6b;
    font-size:10px;
}
.receiving-progress-label {
    display:flex;
    justify-content:space-between;
    gap:8px;
    margin-top:9px;
    color:#625959;
    font-size:10px;
}
.receiving-progress-track {
    height:5px;
    margin-top:6px;
    background:#f4e5e5;
}
.receiving-progress-track span {
    display:block;
    height:100%;
    background:#B60000;
}
.receiving-empty-queue {
    padding:16px;
    border:1px solid #efdada;
    background:#fff;
    color:#756b6b;
    font-size:11px;
}
.receiving-panel {
    min-width:0;
    background:#fff;
    border:1px solid #efdada;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
    overflow:hidden;
}
.receiving-panel-head {
    padding:17px 18px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.receiving-panel-head h2 {
    font-size:14px;
    color:#8C0000;
}
.receiving-panel-body {
    padding:18px;
}
.receiving-form {
    margin:18px 0;
}
.receiving-form summary {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:13px 16px;
    border-left:4px solid #B60000;
    background:#fffafa;
    color:#8C0000;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    list-style:none;
}
.receiving-form summary::-webkit-details-marker {
    display:none;
}
.receiving-form summary::after {
    content:'+';
    font-size:20px;
    line-height:1;
}
.receiving-form[open] summary::after {
    content:'−';
}
.receiving-form-body {
    padding:16px;
    border-top:1px solid #f1e1e1;
}
.receiving-fields {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:0 18px;
}
.receiving-field-wide {
    grid-column:span 2;
}
.receiving-field {
    margin-bottom:14px;
}
.receiving-field label {
    display:block;
    margin-bottom:6px;
    font-size:11px;
    font-weight:600;
}
.receiving-field input,.receiving-field select,.receiving-field textarea {
    width:100%;
    min-height:39px;
    padding:9px 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    color:#302727;
    font:12px 'Inter',sans-serif;
    transition:border-color .2s,box-shadow .2s;
}
.receiving-field input:focus,.receiving-field select:focus,.receiving-field textarea:focus {
    outline:none;
    border-color:#B60000;
    box-shadow:0 0 0 3px rgba(182,0,0,.09);
}
.receiving-field textarea {
    resize:vertical;
    min-height:72px;
}
.receiving-actions {
    display:flex;
    gap:8px;
    align-items:center;
    flex-wrap:wrap;
}
.receiving-button,.receiving-cancel {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:38px;
    padding:0 13px;
    border:1px solid #B60000;
    font:500 11px 'Inter',sans-serif;
    text-decoration:none;
    cursor:pointer;
}
.receiving-button {
    background:#B60000;
    color:#fff;
}
.receiving-button:hover {
    background:#8C0000;
}
.receiving-button:disabled {
    background:#c9a4a4;
    border-color:#c9a4a4;
    cursor:not-allowed;
}
.receiving-cancel {
    background:#fff;
    color:#625959;
    border-color:#d5d0d0;
}
.receiving-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.receiving-warning {
    padding:12px 14px;
    margin-bottom:16px;
    background:#fff5f5;
    border-left:3px solid #B60000;
    color:#665b5b;
    font-size:11px;
    line-height:1.7;
}
.receiving-warning a {
    color:#8C0000;
    font-weight:600;
}
.receiving-error {
    margin-top:4px;
    color:#B60000;
    font-size:10px;
}
.receiving-list-head {
    display:flex;
    justify-content:space-between;
    gap:12px;
    align-items:center;
    padding:15px 17px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.receiving-list-head h2 {
    font-size:14px;
    color:#8C0000;
}
.receiving-count {
    color:#756b6b;
    font-size:11px;
}
.receiving-table-wrap {
    width:100%;
    min-width:0;
    max-width:100%;
    overflow-x:auto;
}
.receiving-table {
    width:100%;
    border-collapse:collapse;
    text-align:left;
    font-size:11px;
}
.receiving-table th {
    padding:11px 12px;
    background:#fff2f2;
    color:#625959;
    font-weight:600;
    white-space:nowrap;
}
.receiving-table td {
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:top;
}
.receiving-table tbody tr:hover {
    background:#fffafa;
}
.receiving-name {
    font-weight:600;
    color:#302727;
}
.receiving-secondary {
    display:block;
    margin-top:3px;
    color:#756b6b;
    font-size:10px;
}
.receiving-row-actions {
    display:flex;
    gap:7px;
    align-items:center;
    white-space:nowrap;
}
.receiving-row-actions form {
    margin:0;
}
.receiving-row-actions a,.receiving-row-actions button {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:64px;
    min-height:30px;
    padding:0 9px;
    border:1px solid #d99a9a;
    background:#fff;
    color:#8C0000;
    font:600 10px 'Inter',sans-serif;
    text-decoration:none;
    cursor:pointer;
    transition:background .15s,border-color .15s,color .15s;
}
.receiving-row-actions a:hover {
    background:#B60000;
    border-color:#B60000;
    color:#fff;
}
.receiving-row-actions button {
    border-color:#efcaca;
    background:#fff5f5;
    color:#a12828;
}
.receiving-row-actions button:hover {
    border-color:#a12828;
    background:#a12828;
    color:#fff;
}
.receiving-row-actions a:focus-visible,.receiving-row-actions button:focus-visible,.receiving-button:focus-visible,.receiving-cancel:focus-visible {
    outline:3px solid rgba(182,0,0,.2);
    outline-offset:2px;
}
.receiving-empty {
    padding:34px 16px!important;
    text-align:center;
    color:#756b6b;
}
@media(max-width:900px) {
    .receiving-fields {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .receiving-field-wide {
        grid-column:1/-1;
    }
}
@media(max-width:600px) {
    .receiving-fields {
        grid-template-columns:1fr;
    }
    .receiving-field-wide {
        grid-column:auto;
    }
    .receiving-panel-head,.receiving-panel-body,.receiving-form-body {
        padding:14px;
    }
    .receiving-list-head {
        align-items:stretch;
        flex-direction:column;
    }
    .receiving-queue-item {
        padding:11px 12px;
    }
    .receiving-queue-top {
        flex-direction:column;
        gap:4px;
    }
    .receiving-table td {
        padding:10px;
    }
    .receiving-row-actions {
        flex-direction:column;
        align-items:stretch;
    }
    .receiving-row-actions a,.receiving-row-actions button {
        min-width:58px;
    }
}
</style>

<div class="receiving-page">
    <p class="receiving-intro">Catat jumlah bahan yang benar-benar diterima untuk setiap rencana pembelian.</p>

    @if(session('success'))
        <div class="receiving-notice">{{ session('success') }}</div>
    @endif

    @if(!$receipt && count($purchases) === 0)
        <div class="receiving-warning">
            Belum ada rencana pembelian. Buat rencana terlebih dahulu di
            <a href="{{ route('pemilik.pembelian.index') }}">menu Pembelian</a>.
        </div>
    @endif

    <div class="receiving-section-title">
        <h2>Rencana Menunggu Penerimaan</h2>
        <span>{{ count($purchases) }} rencana pembelian</span>
    </div>

    @if(count($purchases) > 0)
        <div class="receiving-queue">
            @foreach($purchases as $item)
                @php
                    $receivedAmount = collect($receipts)
                        ->where('purchase_id', $item['id'])
                        ->sum(fn ($existing) => (float) $existing['jumlah']);
                    $plannedAmount = (float) $item['jumlah'];
                    $progress = $plannedAmount > 0 ? min(100, ($receivedAmount / $plannedAmount) * 100) : 0;
                    $remainingAmount = max(0, $plannedAmount - $receivedAmount);
                @endphp
                <article class="receiving-queue-item">
                    <div class="receiving-queue-top">
                        <strong>{{ $item['material_nama'] }}</strong>
                        <span>{{ $item['supplier_nama'] }}</span>
                    </div>
                    <p class="receiving-queue-meta">Rencana {{ $item['jumlah'] }} {{ $item['satuan'] }} · {{ \Illuminate\Support\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</p>
                    <div class="receiving-progress-label">
                        <span>Diterima {{ $receivedAmount }} {{ $item['satuan'] }}</span>
                        <strong>{{ $remainingAmount > 0 ? 'Sisa '.$remainingAmount.' '.$item['satuan'] : 'Lengkap' }}</strong>
                    </div>
                    <div class="receiving-progress-track"><span style="width:{{ $progress }}%"></span></div>
                </article>
            @endforeach
        </div>
    @else
        <div class="receiving-empty-queue">Belum ada rencana untuk ditampilkan.</div>
    @endif

    <details class="receiving-panel receiving-form" @if($receipt) open @endif>
        <summary>{{ $receipt ? 'Ubah data penerimaan' : 'Catat bahan yang diterima' }}</summary>
        <div class="receiving-form-body">
                <form action="{{ $receipt ? route('pemilik.penerimaan.update', $receipt['id']) : route('pemilik.penerimaan.store') }}" method="POST">
                    @csrf
                    @if($receipt)
                        @method('PUT')
                    @endif

                    <div class="receiving-fields">
                    <div class="receiving-field">
                        <label for="purchase_id">Rencana Pembelian *</label>
                        <select id="purchase_id" name="purchase_id" required>
                            <option value="">Pilih rencana pembelian</option>
                            @foreach($purchases as $item)
                                @php
                                    $receivedAmount = collect($receipts)
                                        ->filter(fn ($existing, $key) => $key !== array_search($receipt['id'] ?? null, array_column($receipts, 'id'), true)
                                            && $existing['purchase_id'] === $item['id'])
                                        ->sum(fn ($existing) => (float) $existing['jumlah']);
                                    $remainingAmount = max(0, (float) $item['jumlah'] - $receivedAmount);
                                @endphp
                                @if($remainingAmount > 0 || ($receipt && $receipt['purchase_id'] === $item['id']))
                                    <option value="{{ $item['id'] }}" @selected(old('purchase_id', $receipt['purchase_id'] ?? '') === $item['id'])>
                                        {{ $item['supplier_nama'] }} · {{ $item['material_nama'] }} · sisa {{ $remainingAmount }} {{ $item['satuan'] }}
                                    </option>
                                @endif
                            @endforeach
                            @if($receipt && !in_array($receipt['purchase_id'], array_column($purchases, 'id'), true))
                                <option value="{{ $receipt['purchase_id'] }}" selected>{{ $receipt['supplier_nama'] }} · {{ $receipt['material_nama'] }} (data lama)</option>
                            @endif
                        </select>
                        @error('purchase_id')<p class="receiving-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="receiving-field">
                        <label for="tanggal">Tanggal Penerimaan *</label>
                        <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $receipt['tanggal'] ?? now()->format('Y-m-d')) }}" required>
                        @error('tanggal')<p class="receiving-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="receiving-field">
                        <label for="jumlah">Jumlah Diterima *</label>
                        <input id="jumlah" name="jumlah" type="number" min="1" max="999999" step="1" value="{{ old('jumlah', $receipt['jumlah'] ?? '') }}" required>
                        @error('jumlah')<p class="receiving-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="receiving-field receiving-field-wide">
                        <label for="catatan">Catatan Pemeriksaan</label>
                        <textarea id="catatan" name="catatan" maxlength="255" placeholder="Kondisi bahan atau catatan lain (opsional)">{{ old('catatan', $receipt['catatan'] ?? '') }}</textarea>
                        @error('catatan')<p class="receiving-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="receiving-actions">
                        <button class="receiving-button" type="submit" @disabled(!$receipt && count($purchases) === 0)>{{ $receipt ? 'Simpan Perubahan' : 'Catat Penerimaan' }}</button>
                        @if($receipt)
                            <a class="receiving-cancel" href="{{ route('pemilik.penerimaan.index') }}">Batal</a>
                        @endif
                    </div>
                    </div>
                </form>
        </div>
    </details>

    <section class="receiving-panel">
            <div class="receiving-list-head">
                <h2>Riwayat Penerimaan</h2>
                <span class="receiving-count">{{ count($receipts) }} penerimaan</span>
            </div>
            <div class="receiving-table-wrap">
                <table class="receiving-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Supplier</th><th>Bahan</th><th>Diterima</th><th>Rencana</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse(array_reverse($receipts) as $item)
                            <tr>
                                <td>{{ \Illuminate\Support\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                                <td>{{ $item['supplier_nama'] }}</td>
                                <td><span class="receiving-name">{{ $item['material_nama'] }}</span></td>
                                <td>{{ $item['jumlah'] }} {{ $item['satuan'] }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($purchases[array_search($item['purchase_id'], array_column($purchases, 'id'), true)]['tanggal'] ?? $item['tanggal'])->format('d/m/Y') }}</td>
                                <td>
                                    <div class="receiving-row-actions">
                                        <a href="{{ route('pemilik.penerimaan.edit', $item['id']) }}">Ubah</a>
                                        <form action="{{ route('pemilik.penerimaan.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus data penerimaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="receiving-empty" colspan="6">Belum ada penerimaan bahan yang dicatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
</div>
@endsection