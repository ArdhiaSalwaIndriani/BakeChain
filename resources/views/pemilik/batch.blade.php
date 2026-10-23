@extends('pemilik.layout')

@section('title', 'Batch & Kedaluwarsa')
@section('heading', 'Kelola Batch Bahan')
@section('subtitle', 'Kelola kode batch, jumlah, tanggal masuk, dan kedaluwarsa.')

@section('content')
<style>
.batch-page {
    color:#302727;
}
.batch-intro {
    margin-bottom:20px;
    color:#756b6b;
    font-size:12px;
}
.batch-summary {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    margin-bottom:18px;
    border-top:1px solid #efdada;
    border-bottom:1px solid #efdada;
    background:#fff;
}
.batch-summary-item {
    padding:14px 17px;
    border-right:1px solid #efdada;
}
.batch-summary-item:last-child {
    border-right:0;
}
.batch-summary-item strong {
    display:block;
    color:#8C0000;
    font-size:20px;
}
.batch-summary-item span {
    display:block;
    margin-top:4px;
    color:#756b6b;
    font-size:10px;
}
.batch-form,.batch-board {
    background:#fff;
    border:1px solid #efdada;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
}
.batch-form {
    margin-bottom:18px;
}
.batch-form summary {
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
.batch-form summary::-webkit-details-marker {
    display:none;
}
.batch-form summary::after {
    content:'+';
    font-size:20px;
    line-height:1;
}
.batch-form[open] summary::after {
    content:'−';
}
.batch-form-body {
    padding:16px;
    border-top:1px solid #f1e1e1;
}
.batch-fields {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:0 18px;
}
.batch-field-wide {
    grid-column:span 2;
}
.batch-origin-grid {
    grid-column:1/-1;
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    margin-bottom:14px;
    border:1px solid #efdada;
    background:#fffafa;
}
.batch-origin-item {
    min-width:0;
    padding:11px 12px;
    border-right:1px solid #efdada;
}
.batch-origin-item:last-child {
    border-right:0;
}
.batch-origin-item span {
    display:block;
    margin-bottom:5px;
    color:#8b7e7e;
    font-size:9px;
    text-transform:uppercase;
}
.batch-origin-item strong {
    display:block;
    color:#302727;
    font-size:11px;
    overflow-wrap:anywhere;
}
.batch-field-help {
    margin-top:5px;
    color:#756b6b;
    font-size:10px;
}
.batch-field {
    margin-bottom:14px;
}
.batch-field label {
    display:block;
    margin-bottom:6px;
    font-size:11px;
    font-weight:600;
}
.batch-field input,.batch-field select,.batch-field textarea {
    width:100%;
    min-height:39px;
    padding:9px 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    color:#302727;
    font:12px 'Inter',sans-serif;
    transition:border-color .2s,box-shadow .2s;
}
.batch-field input:focus,.batch-field select:focus,.batch-field textarea:focus {
    outline:none;
    border-color:#B60000;
    box-shadow:0 0 0 3px rgba(182,0,0,.09);
}
.batch-field textarea {
    resize:vertical;
    min-height:72px;
}
.batch-actions {
    grid-column:1/-1;
    display:flex;
    justify-content:flex-end;
    gap:8px;
    align-items:center;
    flex-wrap:wrap;
}
.batch-button,.batch-cancel {
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
.batch-button {
    background:#B60000;
    color:#fff;
}
.batch-button:hover {
    background:#8C0000;
}
.batch-button:disabled {
    background:#c9a4a4;
    border-color:#c9a4a4;
    cursor:not-allowed;
}
.batch-cancel {
    background:#fff;
    color:#625959;
    border-color:#d5d0d0;
}
.batch-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.batch-warning {
    padding:12px 14px;
    margin-bottom:16px;
    background:#fff5f5;
    border-left:3px solid #B60000;
    color:#665b5b;
    font-size:11px;
    line-height:1.7;
}
.batch-warning a {
    color:#8C0000;
    font-weight:600;
}
.batch-error {
    margin-top:4px;
    color:#B60000;
    font-size:10px;
}
.batch-board-head {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:15px 17px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.batch-board-head h2 {
    font-size:14px;
    color:#8C0000;
}
.batch-count {
    color:#756b6b;
    font-size:11px;
}
.batch-card-list {
    display:grid;
    grid-template-columns:minmax(0,1fr);
    gap:0;
}
.batch-card {
    display:grid;
    grid-template-columns:minmax(0,1fr) 112px auto;
    align-items:center;
    gap:14px;
    padding:0 16px;
    border-bottom:1px solid #eee;
}
.batch-card-main {
    min-width:0;
    padding:12px 0;
}
.batch-card-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
}
.batch-code {
    font-weight:700;
    color:#8C0000;
    overflow-wrap:anywhere;
}
.batch-state {
    padding:4px 6px;
    border:1px solid #d9e6d7;
    background:#f3f8f2;
    color:#28652B;
    font-size:9px;
    white-space:nowrap;
}
.batch-state.soon {
    border-color:#e8d39b;
    background:#fff9e9;
    color:#8a5a00;
}
.batch-state.expired {
    border-color:#efcaca;
    background:#fff3f3;
    color:#a12828;
}
.batch-ingredient {
    display:inline-block;
    margin-top:7px;
    margin-right:12px;
    font-size:12px;
    font-weight:600;
    color:#302727;
}
.batch-supplier {
    display:inline-block;
    margin-top:3px;
    color:#756b6b;
    font-size:10px;
}
.batch-facts {
    display:grid;
    grid-template-columns:repeat(2,minmax(130px,1fr));
    gap:8px 16px;
    max-width:360px;
    margin-top:9px;
}
.batch-facts span {
    display:block;
    margin-bottom:4px;
    color:#8b7e7e;
    font-size:9px;
    text-transform:uppercase;
}
.batch-facts strong {
    font-size:11px;
    color:#302727;
}
.batch-card-quantity {
    display:flex;
    min-width:100px;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    align-self:stretch;
    padding:10px;
    background:#fff5f5;
    border-left:1px solid #efdada;
    text-align:center;
}
.batch-card-quantity strong {
    font-size:20px;
    color:#8C0000;
    overflow-wrap:anywhere;
}
.batch-card-quantity span {
    margin-top:4px;
    color:#756b6b;
    font-size:10px;
}
.batch-card-footer {
    display:flex;
    justify-content:flex-end;
    padding:0;
}
.batch-secondary {
    display:block;
    margin-top:3px;
    color:#756b6b;
    font-size:10px;
}
.batch-row-actions {
    display:flex;
    gap:7px;
    align-items:center;
    white-space:nowrap;
}
.batch-row-actions form {
    margin:0;
}
.batch-row-actions a,.batch-row-actions button {
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
.batch-row-actions a:hover {
    background:#B60000;
    border-color:#B60000;
    color:#fff;
}
.batch-row-actions button {
    border-color:#efcaca;
    background:#fff5f5;
    color:#a12828;
}
.batch-row-actions button:hover {
    border-color:#a12828;
    background:#a12828;
    color:#fff;
}
.batch-row-actions a:focus-visible,.batch-row-actions button:focus-visible,.batch-button:focus-visible,.batch-cancel:focus-visible {
    outline:3px solid rgba(182,0,0,.2);
    outline-offset:2px;
}
.batch-empty {
    padding:28px 16px;
    text-align:center;
    color:#756b6b;
    grid-column:1/-1;
}
@media(max-width:1000px) {
    .batch-fields {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .batch-field-wide {
        grid-column:1/-1;
    }
    .batch-origin-grid {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .batch-origin-item:nth-child(2) {
        border-right:0;
    }
    .batch-origin-item:nth-child(-n+2) {
        border-bottom:1px solid #efdada;
    }
    .batch-card {
        grid-template-columns:minmax(0,1fr) 100px;
        gap:12px;
    }
    .batch-card-main {
        grid-column:1;
        grid-row:1;
        padding:11px 0;
    }
    .batch-card-quantity {
        grid-column:2;
        grid-row:1/3;
    }
    .batch-card-footer {
        grid-column:1/-1;
        justify-content:flex-end;
        padding:0 0 10px;
    }
}
@media(max-width:600px) {
    .batch-summary-item {
        padding:12px 10px;
    }
    .batch-summary-item strong {
        font-size:17px;
    }
    .batch-form-body {
        padding:14px;
    }
    .batch-fields {
        grid-template-columns:1fr;
    }
    .batch-field-wide {
        grid-column:auto;
    }
    .batch-origin-grid {
        grid-template-columns:1fr 1fr;
    }
    .batch-origin-item {
        padding:10px;
    }
    .batch-origin-item:nth-child(2) {
        border-right:0;
    }
    .batch-origin-item:nth-child(3) {
        border-right:1px solid #efdada;
    }
    .batch-origin-item:nth-child(-n+2) {
        border-bottom:1px solid #efdada;
    }
    .batch-board-head {
        align-items:flex-start;
        flex-direction:column;
    }
    .batch-card {
        grid-template-columns:minmax(0,1fr) 92px;
        padding:0 12px;
        gap:10px;
    }
    .batch-card-quantity {
        min-width:0;
        padding:8px;
    }
    .batch-card-quantity strong {
        font-size:17px;
    }
    .batch-card-footer {
        padding:0 0 10px;
    }
}
</style>

<div class="batch-page">
    <p class="batch-intro">Batch dibuat dari penerimaan bahan agar asal supplier dan tanggal masuk tercatat.</p>

    @if(session('success'))
        <div class="batch-notice">{{ session('success') }}</div>
    @endif

    @php
        $today = now()->startOfDay();
        $soonDate = $today->copy()->addDays(30);
        $expiredCount = 0;
        $soonCount = 0;
        foreach ($batches as $summaryBatch) {
            $expiry = \Illuminate\Support\Carbon::parse($summaryBatch['tanggal_kedaluwarsa'])->startOfDay();
            $expiredCount += $expiry->lt($today) ? 1 : 0;
            $soonCount += !$expiry->lt($today) && $expiry->lte($soonDate) ? 1 : 0;
        }
        $hasAvailableReceipt = false;
        foreach ($receipts as $receiptItem) {
            $assignedAmount = collect($batches)
                ->filter(fn ($item) => $item['receipt_id'] === $receiptItem['id']
                    && (!$batch || $item['id'] !== $batch['id']))
                ->sum(fn ($item) => (float) $item['jumlah']);
            if ($assignedAmount < (float) $receiptItem['jumlah']) {
                $hasAvailableReceipt = true;
            }
        }
        $selectedReceiptId = old('receipt_id', $batch['receipt_id'] ?? '');
        $selectedReceipt = collect($receipts)->firstWhere('id', $selectedReceiptId);
        $selectedAssignedAmount = $selectedReceipt
            ? collect($batches)
                ->filter(fn ($item) => $item['receipt_id'] === $selectedReceipt['id']
                    && (!$batch || $item['id'] !== $batch['id']))
                ->sum(fn ($item) => (float) $item['jumlah'])
            : 0;
        $selectedRemaining = $selectedReceipt
            ? max(0, (float) $selectedReceipt['jumlah'] - $selectedAssignedAmount)
            : null;
    @endphp

    @if(!$batch && count($receipts) === 0)
        <div class="batch-warning">
            Catat penerimaan bahan terlebih dahulu di
            <a href="{{ route('pemilik.penerimaan.index') }}">menu Penerimaan Bahan</a>.
        </div>
    @elseif(!$batch && !$hasAvailableReceipt)
        <div class="batch-warning">Semua jumlah penerimaan sudah dialokasikan ke batch.</div>
    @endif

    <div class="batch-summary">
        <div class="batch-summary-item"><strong>{{ count($batches) }}</strong><span>Total batch</span></div>
        <div class="batch-summary-item"><strong>{{ $soonCount }}</strong><span>Masuk masa kedaluwarsa (30 hari)</span></div>
        <div class="batch-summary-item"><strong>{{ $expiredCount }}</strong><span>Sudah melewati tanggal kedaluwarsa</span></div>
    </div>

    <details class="batch-form" @if($batch || count($batches) === 0) open @endif>
        <summary>{{ $batch ? 'Ubah data batch' : 'Tambah batch dari penerimaan' }}</summary>
        <div class="batch-form-body">
                <form action="{{ $batch ? route('pemilik.batch.update', $batch['id']) : route('pemilik.batch.store') }}" method="POST">
                    @csrf
                    @if($batch)
                        @method('PUT')
                    @endif

                    <div class="batch-fields">
                    <div class="batch-field">
                        <label for="receipt_id">Sumber Penerimaan *</label>
                        <select id="receipt_id" name="receipt_id" required>
                            <option value="">Pilih penerimaan</option>
                            @foreach($receipts as $item)
                                @php
                                    $assignedAmount = collect($batches)
                                        ->filter(fn ($existing) => $existing['receipt_id'] === $item['id']
                                            && (!$batch || $existing['id'] !== $batch['id']))
                                        ->sum(fn ($existing) => (float) $existing['jumlah']);
                                    $remainingAmount = max(0, (float) $item['jumlah'] - $assignedAmount);
                                @endphp
                                @if($remainingAmount > 0 || ($batch && $batch['receipt_id'] === $item['id']))
                                    <option value="{{ $item['id'] }}" data-supplier="{{ $item['supplier_nama'] }}" data-material="{{ $item['material_nama'] }}" data-received="{{ $item['jumlah'] }}" data-unit="{{ $item['satuan'] }}" data-date="{{ $item['tanggal'] }}" data-remaining="{{ $remainingAmount }}" @selected($selectedReceiptId === $item['id'])>
                                        {{ $item['material_nama'] }} · {{ $item['supplier_nama'] }} · tersedia {{ $remainingAmount }} {{ $item['satuan'] }}
                                    </option>
                                @endif
                            @endforeach
                            @if($batch && !in_array($batch['receipt_id'], array_column($receipts, 'id'), true))
                                <option value="{{ $batch['receipt_id'] }}" data-supplier="{{ $batch['supplier_nama'] }}" data-material="{{ $batch['material_nama'] }}" data-received="{{ $batch['jumlah'] }}" data-unit="{{ $batch['satuan'] }}" data-date="{{ $batch['tanggal_masuk'] }}" data-remaining="{{ $batch['jumlah'] }}" selected>{{ $batch['material_nama'] }} · {{ $batch['supplier_nama'] }} (data lama)</option>
                            @endif
                        </select>
                        @error('receipt_id')<p class="batch-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="batch-origin-grid" aria-live="polite">
                        <div class="batch-origin-item"><span>Supplier</span><strong id="batchSupplier">{{ $selectedReceipt['supplier_nama'] ?? ($batch['supplier_nama'] ?? 'Pilih sumber penerimaan') }}</strong></div>
                        <div class="batch-origin-item"><span>Bahan Baku</span><strong id="batchMaterial">{{ $selectedReceipt['material_nama'] ?? ($batch['material_nama'] ?? 'Belum dipilih') }}</strong></div>
                        <div class="batch-origin-item"><span>Jumlah Diterima</span><strong id="batchReceived">{{ $selectedReceipt ? $selectedReceipt['jumlah'].' '.$selectedReceipt['satuan'] : ($batch ? $batch['jumlah'].' '.$batch['satuan'] : 'Belum tersedia') }}</strong></div>
                        <div class="batch-origin-item"><span>Tanggal Masuk</span><strong id="batchEntryDate">{{ $selectedReceipt ? \Illuminate\Support\Carbon::parse($selectedReceipt['tanggal'])->format('d/m/Y') : ($batch ? \Illuminate\Support\Carbon::parse($batch['tanggal_masuk'])->format('d/m/Y') : 'Belum tersedia') }}</strong></div>
                    </div>

                    <div class="batch-field">
                        <label for="kode_batch">Kode Batch *</label>
                        <input id="kode_batch" name="kode_batch" type="text" maxlength="50" value="{{ old('kode_batch', $batch['kode_batch'] ?? '') }}" placeholder="Contoh: TEP-20261016-01" required>
                        @error('kode_batch')<p class="batch-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="batch-field">
                        <label for="jumlah">Jumlah dalam Batch *</label>
                        <input id="jumlah" name="jumlah" type="number" min="1" max="{{ $selectedRemaining ?? 999999 }}" step="1" value="{{ old('jumlah', $batch['jumlah'] ?? '') }}" required>
                        <p class="batch-field-help" id="batchRemaining">Sisa penerimaan yang bisa dibuat batch: {{ $selectedReceipt ? $selectedRemaining.' '.$selectedReceipt['satuan'] : 'pilih sumber penerimaan' }}.</p>
                        @error('jumlah')<p class="batch-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="batch-field">
                        <label for="tanggal_kedaluwarsa">Tanggal Kedaluwarsa *</label>
                        <input id="tanggal_kedaluwarsa" name="tanggal_kedaluwarsa" type="date" min="{{ $selectedReceipt['tanggal'] ?? ($batch['tanggal_masuk'] ?? now()->format('Y-m-d')) }}" value="{{ old('tanggal_kedaluwarsa', $batch['tanggal_kedaluwarsa'] ?? '') }}" required>
                        @error('tanggal_kedaluwarsa')<p class="batch-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="batch-field batch-field-wide">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" maxlength="255" placeholder="Catatan batch (opsional)">{{ old('catatan', $batch['catatan'] ?? '') }}</textarea>
                        @error('catatan')<p class="batch-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="batch-actions">
                        <button class="batch-button" type="submit" @disabled(!$batch && !$hasAvailableReceipt)>{{ $batch ? 'Simpan Perubahan' : 'Tambah Batch' }}</button>
                        @if($batch)
                            <a class="batch-cancel" href="{{ route('pemilik.batch.index') }}">Batal</a>
                        @endif
                    </div>
                    </div>
                </form>
        </div>
    </details>

    <section class="batch-board">
            <div class="batch-board-head">
                <h2>Daftar Batch</h2>
                <span class="batch-count">{{ count($batches) }} batch</span>
            </div>
            <div class="batch-card-list">
                @forelse(collect($batches)->sortBy('tanggal_kedaluwarsa') as $item)
                    @php
                        $itemExpiry = \Illuminate\Support\Carbon::parse($item['tanggal_kedaluwarsa'])->startOfDay();
                        $isExpired = $itemExpiry->lt($today);
                        $isSoon = !$isExpired && $itemExpiry->lte($soonDate);
                    @endphp
                    <article class="batch-card">
                        <div class="batch-card-main">
                            <div class="batch-card-top">
                                <strong class="batch-code">{{ $item['kode_batch'] }}</strong>
                                <span class="batch-state {{ $isExpired ? 'expired' : ($isSoon ? 'soon' : '') }}">{{ $isExpired ? 'Kedaluwarsa' : ($isSoon ? 'Segera' : 'Aman') }}</span>
                            </div>
                            <p class="batch-ingredient">{{ $item['material_nama'] }}</p>
                            <p class="batch-supplier">Supplier · {{ $item['supplier_nama'] }}</p>
                            <div class="batch-facts">
                                <div><span>Tanggal Masuk</span><strong>{{ \Illuminate\Support\Carbon::parse($item['tanggal_masuk'])->format('d/m/Y') }}</strong></div>
                                <div><span>Kedaluwarsa</span><strong>{{ \Illuminate\Support\Carbon::parse($item['tanggal_kedaluwarsa'])->format('d/m/Y') }}</strong></div>
                            </div>
                        </div>
                        <div class="batch-card-quantity">
                            <strong>{{ $item['jumlah'] }}</strong>
                            <span>{{ $item['satuan'] }} tersedia</span>
                        </div>
                        <footer class="batch-card-footer">
                            <div class="batch-row-actions">
                                <a href="{{ route('pemilik.batch.edit', $item['id']) }}">Ubah</a>
                                <form action="{{ route('pemilik.batch.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus batch ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </div>
                        </footer>
                    </article>
                @empty
                    <p class="batch-empty">Belum ada batch yang dicatat.</p>
                @endforelse
            </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const receiptSelect = document.getElementById('receipt_id');
    const quantity = document.getElementById('jumlah');
    const expiry = document.getElementById('tanggal_kedaluwarsa');

    receiptSelect.addEventListener('change', function () {
        const option = receiptSelect.selectedOptions[0];
        const selected = option && option.value ? option.dataset : null;

        document.getElementById('batchSupplier').textContent = selected?.supplier || 'Pilih sumber penerimaan';
        document.getElementById('batchMaterial').textContent = selected?.material || 'Belum dipilih';
        document.getElementById('batchReceived').textContent = selected ? `${selected.received} ${selected.unit}` : 'Belum tersedia';
        document.getElementById('batchEntryDate').textContent = selected ? selected.date.split('-').reverse().join('/') : 'Belum tersedia';
        document.getElementById('batchRemaining').textContent = selected
            ? `Sisa penerimaan yang bisa dibuat batch: ${selected.remaining} ${selected.unit}.`
            : 'Sisa penerimaan yang bisa dibuat batch: pilih sumber penerimaan.';

        quantity.max = selected ? selected.remaining : '999999';
        expiry.min = selected ? selected.date : '{{ now()->format('Y-m-d') }}';
    });
});
</script>
@endsection