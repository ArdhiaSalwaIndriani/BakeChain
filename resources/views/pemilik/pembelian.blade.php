@extends('pemilik.layout')

@section('title', 'Pembelian')
@section('heading', 'Kelola Pembelian')
@section('subtitle', 'Catat rencana pembelian bahan dan supplier pilihan.')

@section('content')
<style>
.purchase-page {
    color:#302727;
}
.purchase-intro {
    margin-bottom:20px;
    color:#756b6b;
    font-size:12px;
}
.purchase-summary {
    display:grid;
    grid-template-columns:1fr 1fr 2fr;
    margin-bottom:18px;
    border-top:1px solid #efdada;
    border-bottom:1px solid #efdada;
    background:#fff;
}
.purchase-summary-item {
    padding:15px 18px;
    border-right:1px solid #efdada;
}
.purchase-summary-item:last-child {
    border-right:0;
    background:#fffafa;
}
.purchase-summary-item span {
    display:block;
    color:#756b6b;
    font-size:10px;
}
.purchase-summary-item strong {
    display:block;
    margin-top:5px;
    color:#8C0000;
    font-size:20px;
}
.purchase-summary-item:last-child strong {
    font-size:17px;
}
.purchase-form,.purchase-board {
    background:#fff;
    border:1px solid #efdada;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
}
.purchase-form {
    margin-bottom:18px;
}
.purchase-form summary {
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
.purchase-form summary::-webkit-details-marker {
    display:none;
}
.purchase-form summary::after {
    content:'+';
    font-size:20px;
    line-height:1;
}
.purchase-form[open] summary::after {
    content:'−';
}
.purchase-form-body {
    padding:16px;
    border-top:1px solid #f1e1e1;
}
.purchase-fields {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:0 18px;
}
.purchase-field-wide {
    grid-column:1/-1;
}
.purchase-field {
    margin-bottom:14px;
}
.purchase-field label {
    display:block;
    margin-bottom:6px;
    font-size:11px;
    font-weight:600;
}
.purchase-field input,.purchase-field select,.purchase-field textarea {
    width:100%;
    min-height:39px;
    padding:9px 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    color:#302727;
    font:12px 'Inter',sans-serif;
    transition:border-color .2s,box-shadow .2s;
}
.purchase-field input:focus,.purchase-field select:focus,.purchase-field textarea:focus {
    outline:none;
    border-color:#B60000;
    box-shadow:0 0 0 3px rgba(182,0,0,.09);
}
.purchase-field textarea {
    resize:vertical;
    min-height:72px;
}
.purchase-actions {
    display:flex;
    gap:8px;
    align-items:center;
    flex-wrap:wrap;
}
.purchase-button,.purchase-cancel {
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
.purchase-button {
    background:#B60000;
    color:#fff;
}
.purchase-button:hover {
    background:#8C0000;
}
.purchase-button:disabled {
    background:#c9a4a4;
    border-color:#c9a4a4;
    cursor:not-allowed;
}
.purchase-cancel {
    background:#fff;
    color:#625959;
    border-color:#d5d0d0;
}
.purchase-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.purchase-warning {
    padding:12px 14px;
    margin-bottom:16px;
    background:#fff5f5;
    border-left:3px solid #B60000;
    color:#665b5b;
    font-size:11px;
    line-height:1.7;
}
.purchase-warning a {
    color:#8C0000;
    font-weight:600;
}
.purchase-error {
    margin-top:4px;
    color:#B60000;
    font-size:10px;
}
.purchase-board-head {
    display:flex;
    justify-content:space-between;
    gap:12px;
    align-items:center;
    padding:15px 17px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.purchase-board-head h2 {
    font-size:14px;
    color:#8C0000;
}
.purchase-count {
    color:#756b6b;
    font-size:11px;
}
.purchase-orders {
    display:grid;
}
.purchase-order {
    display:grid;
    grid-template-columns:120px minmax(180px,1.4fr) minmax(120px,1fr) 110px auto;
    align-items:center;
    gap:18px;
    padding:16px 18px;
    border-bottom:1px solid #eee;
}
.purchase-order:last-child {
    border-bottom:0;
}
.purchase-order:hover {
    background:#fffafa;
}
.purchase-order-date {
    padding-left:12px;
    border-left:3px solid #B60000;
}
.purchase-order-date span,.purchase-order-info span {
    display:block;
    margin-bottom:4px;
    color:#8b7e7e;
    font-size:9px;
    text-transform:uppercase;
}
.purchase-order-date strong {
    font-size:12px;
    color:#302727;
}
.purchase-order-info strong {
    display:block;
    font-size:12px;
    color:#302727;
    overflow-wrap:anywhere;
}
.purchase-order-info small {
    display:block;
    margin-top:4px;
    color:#756b6b;
    font-size:10px;
}
.purchase-order-amount strong {
    display:block;
    font-size:12px;
    color:#8C0000;
}
.purchase-order-amount small {
    display:block;
    margin-top:4px;
    color:#756b6b;
    font-size:10px;
}
.purchase-table {
    width:100%;
    border-collapse:collapse;
    text-align:left;
    font-size:11px;
}
.purchase-table th {
    padding:11px 12px;
    background:#fff2f2;
    color:#625959;
    font-weight:600;
    white-space:nowrap;
}
.purchase-table td {
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:top;
}
.purchase-table tbody tr:hover {
    background:#fffafa;
}
.purchase-name {
    font-weight:600;
    color:#302727;
}
.purchase-secondary {
    display:block;
    margin-top:3px;
    color:#756b6b;
    font-size:10px;
}
.purchase-status {
    display:inline-block;
    padding:4px 7px;
    border:1px solid #e7b2b2;
    background:#fff5f5;
    color:#8C0000;
    font-size:10px;
    white-space:nowrap;
}
.purchase-row-actions {
    display:flex;
    gap:7px;
    align-items:center;
    white-space:nowrap;
}
.purchase-row-actions form {
    margin:0;
}
.purchase-row-actions a,.purchase-row-actions button {
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
.purchase-row-actions a:hover {
    background:#B60000;
    border-color:#B60000;
    color:#fff;
}
.purchase-row-actions button {
    border-color:#efcaca;
    background:#fff5f5;
    color:#a12828;
}
.purchase-row-actions button:hover {
    border-color:#a12828;
    background:#a12828;
    color:#fff;
}
.purchase-row-actions a:focus-visible,.purchase-row-actions button:focus-visible,.purchase-button:focus-visible,.purchase-cancel:focus-visible {
    outline:3px solid rgba(182,0,0,.2);
    outline-offset:2px;
}
.purchase-empty {
    padding:34px 16px!important;
    text-align:center;
    color:#756b6b;
}
@media(max-width:1000px) {
    .purchase-order {
        grid-template-columns:110px minmax(150px,1fr) minmax(120px,1fr) 100px;
        gap:12px;
    }
    .purchase-order .purchase-row-actions {
        grid-column:2/-1;
        justify-content:flex-end;
    }
}
@media(max-width:760px) {
    .purchase-fields {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .purchase-field-wide {
        grid-column:1/-1;
    }
    .purchase-order {
        grid-template-columns:100px 1fr 1fr;
    }
    .purchase-order .purchase-status {
        justify-self:start;
    }
    .purchase-order .purchase-row-actions {
        grid-column:2/-1;
        justify-content:flex-start;
    }
}
@media(max-width:600px) {
    .purchase-summary {
        grid-template-columns:1fr 1fr;
    }
    .purchase-summary-item:last-child {
        grid-column:1/-1;
        border-top:1px solid #efdada;
    }
    .purchase-summary-item {
        padding:12px;
    }
    .purchase-summary-item strong {
        font-size:18px;
    }
    .purchase-form-body {
        padding:14px;
    }
    .purchase-fields {
        grid-template-columns:1fr;
    }
    .purchase-field-wide {
        grid-column:auto;
    }
    .purchase-order {
        grid-template-columns:1fr 1fr;
        gap:12px;
        padding:14px;
    }
    .purchase-order-date {
        grid-column:1/-1;
    }
    .purchase-order .purchase-row-actions {
        grid-column:1/-1;
    }
    .purchase-row-actions {
        flex-direction:row;
    }
    .purchase-row-actions a,.purchase-row-actions button {
        min-width:58px;
    }
}
</style>

<div class="purchase-page">
    <p class="purchase-intro">Buat daftar kebutuhan bahan sebelum proses pemesanan ke supplier.</p>

    @php
        $estimatedTotal = collect($purchases)->sum(fn ($item) => (float) ($item['total_estimasi'] ?? 0));
        $supplierTotal = count(array_unique(array_column($purchases, 'supplier_nama')));
        $hasEstimate = collect($purchases)->contains(fn ($item) => ($item['total_estimasi'] ?? null) !== null);
    @endphp

    <div class="purchase-summary">
        <div class="purchase-summary-item"><span>Total rencana</span><strong>{{ count($purchases) > 0 ? count($purchases) : 'Belum ada' }}</strong></div>
        <div class="purchase-summary-item"><span>Supplier terlibat</span><strong>{{ $supplierTotal > 0 ? $supplierTotal : 'Belum ada' }}</strong></div>
        <div class="purchase-summary-item"><span>Total estimasi pembelian</span><strong>{{ $hasEstimate ? 'Rp '.number_format($estimatedTotal, 0, ',', '.') : 'Belum ada estimasi' }}</strong></div>
    </div>

    @if(session('success'))
        <div class="purchase-notice">{{ session('success') }}</div>
    @endif

    @if(!$purchase && (count($suppliers) === 0 || count($materials) === 0))
        <div class="purchase-warning">
            Sebelum mencatat pembelian, lengkapi
            @if(count($suppliers) === 0)
                <a href="{{ route('pemilik.supplier.index') }}">data supplier</a>
            @endif
            @if(count($suppliers) === 0 && count($materials) === 0)
                dan
            @endif
            @if(count($materials) === 0)
                <a href="{{ route('pemilik.bahan-baku.index') }}">daftar bahan baku</a>
            @endif.
        </div>
    @endif

    <details class="purchase-form" @if($purchase) open @endif>
        <summary>{{ $purchase ? 'Ubah rencana pembelian' : 'Buat rencana pembelian' }}</summary>
        <div class="purchase-form-body">
                <form action="{{ $purchase ? route('pemilik.pembelian.update', $purchase['id']) : route('pemilik.pembelian.store') }}" method="POST">
                    @csrf
                    @if($purchase)
                        @method('PUT')
                    @endif

                    <div class="purchase-fields">
                    <div class="purchase-field">
                        <label for="supplier_id">Supplier *</label>
                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">Pilih supplier</option>
                            @foreach($suppliers as $item)
                                <option value="{{ $item['id'] }}" @selected(old('supplier_id', $purchase['supplier_id'] ?? '') === $item['id'])>{{ $item['nama'] }}</option>
                            @endforeach
                            @if($purchase && !in_array($purchase['supplier_id'], array_column($suppliers, 'id'), true))
                                <option value="{{ $purchase['supplier_id'] }}" selected>{{ $purchase['supplier_nama'] }} (data lama)</option>
                            @endif
                        </select>
                        @error('supplier_id')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-field">
                        <label for="material_id">Bahan Baku *</label>
                        <select id="material_id" name="material_id" required>
                            <option value="">Pilih bahan baku</option>
                            @foreach($materials as $item)
                                <option value="{{ $item['id'] }}" @selected(old('material_id', $purchase['material_id'] ?? '') === $item['id'])>{{ $item['nama'] }} ({{ $item['satuan'] }})</option>
                            @endforeach
                            @if($purchase && !in_array($purchase['material_id'], array_column($materials, 'id'), true))
                                <option value="{{ $purchase['material_id'] }}" selected>{{ $purchase['material_nama'] }} ({{ $purchase['satuan'] }}, data lama)</option>
                            @endif
                        </select>
                        @error('material_id')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-field">
                        <label for="tanggal">Tanggal Rencana *</label>
                        <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $purchase['tanggal'] ?? now()->format('Y-m-d')) }}" required>
                        @error('tanggal')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-field">
                        <label for="jumlah">Jumlah Dibutuhkan *</label>
                        <input id="jumlah" name="jumlah" type="number" min="1" max="999999" step="1" value="{{ old('jumlah', $purchase['jumlah'] ?? '') }}" required>
                        @error('jumlah')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-field">
                        <label for="harga_per_unit">Perkiraan Harga per Satuan (Rp)</label>
                        <input id="harga_per_unit" name="harga_per_unit" type="number" min="0" max="999999999" step="1" value="{{ old('harga_per_unit', $purchase['harga_per_unit'] ?? '') }}">
                        @error('harga_per_unit')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-field purchase-field-wide">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" maxlength="255" placeholder="Catatan kebutuhan (opsional)">{{ old('catatan', $purchase['catatan'] ?? '') }}</textarea>
                        @error('catatan')<p class="purchase-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="purchase-actions">
                        <button class="purchase-button" type="submit" @disabled(!$purchase && (count($suppliers) === 0 || count($materials) === 0))>{{ $purchase ? 'Simpan Perubahan' : 'Catat Pembelian' }}</button>
                        @if($purchase)
                            <a class="purchase-cancel" href="{{ route('pemilik.pembelian.index') }}">Batal</a>
                        @endif
                    </div>
                    </div>
                </form>
        </div>
    </details>

    <section class="purchase-board">
            <div class="purchase-board-head">
                <h2>Rencana Pembelian</h2>
                <span class="purchase-count">{{ count($purchases) }} rencana</span>
            </div>
            <div class="purchase-orders">
                @forelse(array_reverse($purchases) as $item)
                    <article class="purchase-order">
                        <div class="purchase-order-date">
                            <span>Tanggal rencana</span>
                            <strong>{{ \Illuminate\Support\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</strong>
                        </div>
                        <div class="purchase-order-info">
                            <span>Supplier</span>
                            <strong>{{ $item['supplier_nama'] }}</strong>
                            <small>{{ $item['material_nama'] }}{{ $item['catatan'] ? ' · '.$item['catatan'] : '' }}</small>
                        </div>
                        <div class="purchase-order-amount">
                            <span>Jumlah</span>
                            <strong>{{ $item['jumlah'] }} {{ $item['satuan'] }}</strong>
                            <small>{{ $item['total_estimasi'] === null ? 'Estimasi belum diisi' : 'Rp '.number_format($item['total_estimasi'], 0, ',', '.') }}</small>
                        </div>
                        <span class="purchase-status">{{ $item['status'] }}</span>
                        <div class="purchase-row-actions">
                            <a href="{{ route('pemilik.pembelian.edit', $item['id']) }}">Ubah</a>
                            <form action="{{ route('pemilik.pembelian.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus rencana pembelian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="purchase-empty">Belum ada rencana pembelian yang dicatat.</p>
                @endforelse
            </div>
    </section>
</div>
@endsection