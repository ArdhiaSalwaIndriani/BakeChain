@extends('pemilik.layout')

@section('title', 'Bahan Baku')
@section('heading', 'Kelola Bahan Baku')
@section('subtitle', 'Atur daftar bahan dan batas stok minimum.')

@section('content')
<style>
.materials-page {
    color:#302727;
}
.materials-intro {
    margin-bottom:20px;
    color:#756b6b;
    font-size:12px;
}
.materials-grid {
    display:grid;
    grid-template-columns:minmax(0,1fr);
    gap:18px;
}
.materials-grid>* {
    min-width:0;
}
.materials-summary {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    border-top:1px solid #efdada;
    border-bottom:1px solid #efdada;
    background:#fff;
}
.materials-summary-item {
    padding:16px 18px;
    border-right:1px solid #efdada;
}
.materials-summary-item:last-child {
    border-right:0;
}
.materials-summary-item strong {
    display:block;
    color:#8C0000;
    font-size:21px;
    line-height:1.2;
}
.materials-summary-item span {
    display:block;
    margin-top:5px;
    color:#756b6b;
    font-size:10px;
}
.materials-form,.materials-directory {
    background:#fff;
    border:1px solid #efdada;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
}
.materials-form summary {
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
.materials-form summary::-webkit-details-marker {
    display:none;
}
.materials-form summary::after {
    content:'+';
    font-size:20px;
    line-height:1;
}
.materials-form[open] summary::after {
    content:'−';
}
.materials-form-body {
    padding:16px;
    border-top:1px solid #f1e1e1;
}
.materials-fields {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:0 18px;
}
.materials-field-wide {
    grid-column:span 2;
}
.materials-field {
    margin-bottom:14px;
}
.materials-field label {
    display:block;
    margin-bottom:6px;
    font-size:11px;
    font-weight:600;
}
.materials-field input,.materials-field select,.materials-field textarea {
    width:100%;
    min-height:39px;
    padding:9px 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    color:#302727;
    font:12px 'Inter',sans-serif;
    transition:border-color .2s,box-shadow .2s;
}
.materials-field input:focus,.materials-field select:focus,.materials-field textarea:focus {
    outline:none;
    border-color:#B60000;
    box-shadow:0 0 0 3px rgba(182,0,0,.09);
}
.materials-field textarea {
    resize:vertical;
    min-height:72px;
}
.materials-field select {
    appearance:auto;
}
.materials-actions {
    grid-column:1/-1;
    display:flex;
    justify-content:flex-end;
    gap:8px;
    align-items:center;
    flex-wrap:wrap;
}
.materials-button,.materials-cancel {
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
.materials-button {
    background:#B60000;
    color:#fff;
}
.materials-button:hover {
    background:#8C0000;
}
.materials-cancel {
    background:#fff;
    color:#625959;
    border-color:#d5d0d0;
}
.materials-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.materials-error {
    margin-top:4px;
    color:#B60000;
    font-size:10px;
}
.materials-list-head {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    padding:15px 17px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.materials-list-head h2 {
    font-size:14px;
    color:#8C0000;
}
.materials-count {
    color:#756b6b;
    font-size:11px;
}
.materials-search {
    width:min(260px,100%);
    height:36px;
    padding:0 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    font:11px 'Inter',sans-serif;
}
.materials-search:focus {
    outline:2px solid #f2caca;
    border-color:#B60000;
}
.materials-table-wrap {
    min-width:0;
    max-width:100%;
    overflow-x:auto;
}
.materials-table {
    width:100%;
    table-layout:fixed;
    border-collapse:collapse;
    text-align:left;
    font-size:11px;
}
.materials-table th:nth-child(1) {
    width:25%;
}
.materials-table th:nth-child(2) {
    width:24%;
}
.materials-table th:nth-child(3) {
    width:13%;
}
.materials-table th:nth-child(4) {
    width:20%;
}
.materials-table th:nth-child(5) {
    width:18%;
}
.materials-table th {
    padding:11px 12px;
    background:#fff2f2;
    color:#625959;
    font-weight:600;
    white-space:nowrap;
}
.materials-table td {
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:top;
}
.materials-table th:last-child,.materials-table td:last-child {
    text-align:right;
}
.materials-table td {
    overflow-wrap:anywhere;
}
.materials-table tbody tr:hover {
    background:#fffafa;
}
.materials-name {
    font-weight:600;
    color:#302727;
}
.materials-secondary {
    display:block;
    margin-top:3px;
    color:#756b6b;
    font-size:10px;
}
.materials-row-actions {
    display:flex;
    justify-content:flex-end;
    gap:7px;
    align-items:center;
    white-space:nowrap;
}
.materials-row-actions form {
    margin:0;
}
.materials-row-actions a,.materials-row-actions button {
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
.materials-row-actions a:hover {
    background:#B60000;
    border-color:#B60000;
    color:#fff;
}
.materials-row-actions button {
    border-color:#efcaca;
    background:#fff5f5;
    color:#a12828;
}
.materials-row-actions button:hover {
    border-color:#a12828;
    background:#a12828;
    color:#fff;
}
.materials-row-actions a:focus-visible,.materials-row-actions button:focus-visible,.materials-button:focus-visible,.materials-cancel:focus-visible {
    outline:3px solid rgba(182,0,0,.2);
    outline-offset:2px;
}
.materials-empty {
    padding:34px 16px!important;
    text-align:center;
    color:#756b6b;
}
@media(max-width:900px) {
    .materials-fields {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .materials-field-wide {
        grid-column:1/-1;
    }
}
@media(max-width:600px) {
    .materials-summary-item {
        padding:12px 10px;
    }
    .materials-summary-item strong {
        font-size:18px;
    }
    .materials-fields {
        grid-template-columns:1fr;
    }
    .materials-field-wide {
        grid-column:auto;
    }
    .materials-list-head {
        align-items:stretch;
        flex-direction:column;
    }
    .materials-search {
        width:100%;
    }
    .materials-table {
        min-width:700px;
    }
    .materials-table td {
        padding:10px;
    }
    .materials-row-actions {
        flex-direction:column;
        align-items:stretch;
    }
    .materials-row-actions a,.materials-row-actions button {
        min-width:58px;
    }
}
</style>

<div class="materials-page">
    <p class="materials-intro">Kelola bahan seperti tepung, gula, telur, mentega, dan ragi.</p>

    @if(session('success'))
        <div class="materials-notice">{{ session('success') }}</div>
    @endif

    @php
        $categoryCount = count(array_unique(array_column($materials, 'kategori')));
        $unitCount = count(array_unique(array_column($materials, 'satuan')));
    @endphp

    <div class="materials-grid">
        <div class="materials-summary">
            <div class="materials-summary-item"><strong>{{ count($materials) }}</strong><span>Jenis bahan</span></div>
            <div class="materials-summary-item"><strong>{{ $categoryCount }}</strong><span>Kategori terpakai</span></div>
            <div class="materials-summary-item"><strong>{{ $unitCount }}</strong><span>Satuan digunakan</span></div>
        </div>

        <details class="materials-form" @if($material) open @endif>
            <summary>{{ $material ? 'Ubah data bahan baku' : 'Tambah bahan baku' }}</summary>
            <div class="materials-form-body">
                <form action="{{ $material ? route('pemilik.bahan-baku.update', $material['id']) : route('pemilik.bahan-baku.store') }}" method="POST">
                    @csrf
                    @if($material)
                        @method('PUT')
                    @endif

                    <div class="materials-fields">
                    <div class="materials-field">
                        <label for="nama">Nama Bahan *</label>
                        <input id="nama" name="nama" type="text" maxlength="100" value="{{ old('nama', $material['nama'] ?? '') }}" placeholder="Contoh: Tepung Terigu" required>
                        @error('nama')<p class="materials-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="materials-field">
                        <label for="kategori">Kategori *</label>
                        <select id="kategori" name="kategori" required>
                            <option value="">Pilih kategori</option>
                            @foreach(['Tepung & Serealia','Pemanis','Telur & Produk Susu','Lemak & Minyak','Pengembang','Lainnya'] as $kategori)
                                <option value="{{ $kategori }}" @selected(old('kategori', $material['kategori'] ?? '') === $kategori)>{{ $kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<p class="materials-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="materials-field">
                        <label for="satuan">Satuan *</label>
                        <select id="satuan" name="satuan" required>
                            <option value="">Pilih satuan</option>
                            @foreach(['kg','g','liter','ml','pcs','pack'] as $satuan)
                                <option value="{{ $satuan }}" @selected(old('satuan', $material['satuan'] ?? '') === $satuan)>{{ $satuan }}</option>
                            @endforeach
                        </select>
                        @error('satuan')<p class="materials-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="materials-field">
                        <label for="stok_minimum">Stok Minimum *</label>
                        <input id="stok_minimum" name="stok_minimum" type="number" min="0" max="999999" step="1" value="{{ old('stok_minimum', $material['stok_minimum'] ?? '') }}" required>
                        @error('stok_minimum')<p class="materials-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="materials-field materials-field-wide">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" maxlength="255" placeholder="Catatan tambahan (opsional)">{{ old('catatan', $material['catatan'] ?? '') }}</textarea>
                        @error('catatan')<p class="materials-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="materials-actions">
                        <button class="materials-button" type="submit">{{ $material ? 'Simpan Perubahan' : 'Tambah Bahan' }}</button>
                        @if($material)
                            <a class="materials-cancel" href="{{ route('pemilik.bahan-baku.index') }}">Batal</a>
                        @endif
                    </div>
                    </div>
                </form>
            </div>
        </details>

        <section class="materials-directory">
            <div class="materials-list-head">
                <h2>Daftar Bahan Baku</h2>
                <div class="materials-list-tools">
                    <span class="materials-count">{{ count($materials) }} bahan</span>
                    <input class="materials-search" id="materialsSearch" type="search" placeholder="Cari bahan atau kategori" aria-label="Cari bahan baku">
                </div>
            </div>
            <div class="materials-table-wrap">
                <table class="materials-table">
                    <thead>
                        <tr><th>Nama Bahan</th><th>Kategori</th><th>Satuan</th><th>Stok Minimum</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $item)
                            <tr data-material-row>
                                <td>
                                    <span class="materials-name">{{ $item['nama'] }}</span>
                                    @if($item['catatan'])<span class="materials-secondary">{{ $item['catatan'] }}</span>@endif
                                </td>
                                <td>{{ $item['kategori'] }}</td>
                                <td>{{ $item['satuan'] }}</td>
                                <td>{{ $item['stok_minimum'] }} {{ $item['satuan'] }}</td>
                                <td>
                                    <div class="materials-row-actions">
                                        <a href="{{ route('pemilik.bahan-baku.edit', $item['id']) }}">Ubah</a>
                                        <form action="{{ route('pemilik.bahan-baku.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus bahan baku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="materials-empty" colspan="5">Belum ada bahan baku. Tambahkan bahan pertama melalui formulir.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('materialsSearch');
    const rows = Array.from(document.querySelectorAll('[data-material-row]'));

    search.addEventListener('input', function () {
        const query = search.value.trim().toLowerCase();

        rows.forEach(function (row) {
            row.hidden = !row.innerText.toLowerCase().includes(query);
        });
    });
});
</script>
@endsection