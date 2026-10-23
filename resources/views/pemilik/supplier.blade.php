@extends('pemilik.layout')

@section('title', 'Supplier')
@section('heading', 'Kelola Supplier')
@section('subtitle', 'Kelola pemasok bahan baku dan informasi kontaknya.')

@section('content')
<style>
.supplier-page {
    color:#302727;
}
.supplier-toolbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    margin-bottom:16px;
}
.supplier-intro {
    color:#756b6b;
    font-size:12px;
}
.supplier-count {
    color:#8C0000;
    font-size:11px;
    font-weight:600;
    white-space:nowrap;
}
.supplier-form-panel,.supplier-directory {
    background:#fff;
    border:1px solid #efdada;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
}
.supplier-form-panel {
    margin-bottom:18px;
}
.supplier-form-panel summary {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:15px 18px;
    background:#fffafa;
    border-left:4px solid #B60000;
    color:#8C0000;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    list-style:none;
}
.supplier-form-panel summary::-webkit-details-marker {
    display:none;
}
.supplier-form-panel summary::after {
    content:'+';
    font-size:20px;
    line-height:1;
}
.supplier-form-panel[open] summary::after {
    content:'−';
}
.supplier-form-body {
    padding:18px;
    border-top:1px solid #f1e1e1;
}
.supplier-fields {
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:0 18px;
}
.supplier-field-wide {
    grid-column:1/-1;
}
.supplier-field {
    margin-bottom:14px;
}
.supplier-field label {
    display:block;
    margin-bottom:6px;
    font-size:11px;
    font-weight:600;
}
.supplier-field input,.supplier-field textarea {
    width:100%;
    padding:10px;
    border:1px solid #e3d5d5;
    border-radius:0;
    background:#fff;
    color:#302727;
    font:12px 'Inter',sans-serif;
    transition:border-color .2s,box-shadow .2s;
}
.supplier-field input:focus,.supplier-field textarea:focus {
    outline:none;
    border-color:#B60000;
    box-shadow:0 0 0 3px rgba(182,0,0,.09);
}
.supplier-field textarea {
    resize:vertical;
    min-height:72px;
}
.supplier-actions {
    display:flex;
    gap:8px;
    align-items:center;
    flex-wrap:wrap;
}
.supplier-button,.supplier-cancel {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:38px;
    padding:0 13px;
    border:1px solid #B60000;
    border-radius:0;
    font:500 11px 'Inter',sans-serif;
    text-decoration:none;
    cursor:pointer;
}
.supplier-button {
    background:#B60000;
    color:#fff;
}
.supplier-button:hover {
    background:#8C0000;
}
.supplier-cancel {
    background:#fff;
    color:#625959;
    border-color:#d5d0d0;
}
.supplier-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.supplier-error {
    margin-top:4px;
    color:#B60000;
    font-size:10px;
}
.supplier-directory-head {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    padding:16px 18px;
    border-bottom:1px solid #f1e1e1;
    background:#fffafa;
}
.supplier-directory-head h2 {
    font-size:14px;
    color:#8C0000;
}
.supplier-search {
    width:min(280px,100%);
    height:38px;
    padding:0 10px;
    border:1px solid #e3d5d5;
    background:#fff;
    font:12px 'Inter',sans-serif;
}
.supplier-search:focus {
    outline:2px solid #f2caca;
    border-color:#B60000;
}
.supplier-cards {
    display:grid;
    grid-template-columns:minmax(0,1fr);
    gap:0;
}
.supplier-card {
    padding:18px;
    border-bottom:1px solid #eee;
}
.supplier-card:nth-child(odd) {
    border-right:0;
}
.supplier-card-head {
    display:flex;
    align-items:center;
    gap:12px;
    padding-bottom:14px;
    border-bottom:1px solid #f1e1e1;
}
.supplier-avatar {
    width:42px;
    height:42px;
    display:grid;
    place-items:center;
    background:#B60000;
    color:#fff;
    font-size:16px;
    font-weight:700;
}
.supplier-card-head h3 {
    font-size:13px;
    color:#302727;
    overflow-wrap:anywhere;
}
.supplier-card-head p {
    margin-top:4px;
    color:#756b6b;
    font-size:10px;
}
.supplier-contact {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px 14px;
    padding:14px 0;
}
.supplier-contact span {
    display:block;
    margin-bottom:3px;
    color:#8b7e7e;
    font-size:9px;
    text-transform:uppercase;
}
.supplier-contact p {
    font-size:11px;
    overflow-wrap:anywhere;
}
.supplier-address {
    padding-top:11px;
    border-top:1px solid #f1e1e1;
    color:#625959;
    font-size:11px;
    line-height:1.6;
    overflow-wrap:anywhere;
}
.supplier-card-footer {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-top:14px;
}
.supplier-row-actions {
    display:flex;
    gap:7px;
    align-items:center;
    white-space:nowrap;
}
.supplier-row-actions form {
    margin:0;
}
.supplier-row-actions a,.supplier-row-actions button {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:64px;
    min-height:30px;
    padding:0 9px;
    border:1px solid #d99a9a;
    border-radius:0;
    background:#fff;
    color:#8C0000;
    font:600 10px 'Inter',sans-serif;
    text-decoration:none;
    cursor:pointer;
    transition:background .15s,border-color .15s,color .15s;
}
.supplier-row-actions a:hover {
    background:#B60000;
    border-color:#B60000;
    color:#fff;
}
.supplier-row-actions button {
    border-color:#efcaca;
    background:#fff5f5;
    color:#a12828;
}
.supplier-row-actions button:hover {
    border-color:#a12828;
    background:#a12828;
    color:#fff;
}
.supplier-row-actions a:focus-visible,.supplier-row-actions button:focus-visible,.supplier-button:focus-visible,.supplier-cancel:focus-visible {
    outline:3px solid rgba(182,0,0,.2);
    outline-offset:2px;
}
.supplier-empty {
    padding:34px 16px;
    text-align:center;
    color:#756b6b;
    grid-column:1/-1;
}
.supplier-no-results {
    display:none;
    padding:24px;
    text-align:center;
    color:#756b6b;
    font-size:11px;
}
@media(max-width:850px) {
    .supplier-cards {
        grid-template-columns:1fr;
    }
    .supplier-card:nth-child(odd) {
        border-right:0;
    }
}
@media(max-width:600px) {
    .supplier-toolbar,.supplier-directory-head {
        align-items:stretch;
        flex-direction:column;
    }
    .supplier-search {
        width:100%;
    }
    .supplier-fields {
        grid-template-columns:1fr;
    }
    .supplier-field-wide {
        grid-column:auto;
    }
    .supplier-form-body,.supplier-card {
        padding:14px;
    }
    .supplier-contact {
        grid-template-columns:1fr 1fr;
    }
    .supplier-card-footer {
        align-items:flex-start;
        flex-direction:column;
    }
    .supplier-row-actions {
        flex-direction:row;
    }
    .supplier-row-actions a,.supplier-row-actions button {
        min-width:58px;
    }
}
</style>

<div class="supplier-page">
    <div class="supplier-toolbar">
        <p class="supplier-intro">Catat dan kelola kontak pemasok bahan baku bakery.</p>
        <span class="supplier-count">{{ count($suppliers) }} supplier terdaftar</span>
    </div>

    @if(session('success'))
        <div class="supplier-notice">{{ session('success') }}</div>
    @endif

    <details class="supplier-form-panel" @if($supplier) open @endif>
        <summary>{{ $supplier ? 'Ubah data supplier' : 'Tambah supplier baru' }}</summary>
        <div class="supplier-form-body">
                <form action="{{ $supplier ? route('pemilik.supplier.update', $supplier['id']) : route('pemilik.supplier.store') }}" method="POST">
                    @csrf
                    @if($supplier)
                        @method('PUT')
                    @endif

                    <div class="supplier-fields">
                    <div class="supplier-field">
                        <label for="nama">Nama Supplier *</label>
                        <input id="nama" name="nama" type="text" maxlength="100" value="{{ old('nama', $supplier['nama'] ?? '') }}" required>
                        @error('nama')<p class="supplier-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="supplier-field">
                        <label for="kontak">Nama Kontak</label>
                        <input id="kontak" name="kontak" type="text" maxlength="100" value="{{ old('kontak', $supplier['kontak'] ?? '') }}">
                        @error('kontak')<p class="supplier-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="supplier-field">
                        <label for="telepon">Nomor Telepon</label>
                        <input id="telepon" name="telepon" type="tel" maxlength="30" value="{{ old('telepon', $supplier['telepon'] ?? '') }}">
                        @error('telepon')<p class="supplier-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="supplier-field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" maxlength="150" value="{{ old('email', $supplier['email'] ?? '') }}">
                        @error('email')<p class="supplier-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="supplier-field supplier-field-wide">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" maxlength="255">{{ old('alamat', $supplier['alamat'] ?? '') }}</textarea>
                        @error('alamat')<p class="supplier-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="supplier-actions">
                        <button class="supplier-button" type="submit">{{ $supplier ? 'Simpan Perubahan' : 'Tambah Supplier' }}</button>
                        @if($supplier)
                            <a class="supplier-cancel" href="{{ route('pemilik.supplier.index') }}">Batal</a>
                        @endif
                    </div>
                    </div>
                </form>
        </div>
    </details>

    <section class="supplier-directory">
            <div class="supplier-directory-head">
                <h2>Daftar Supplier</h2>
                <input class="supplier-search" id="supplierSearch" type="search" placeholder="Cari nama atau kontak" aria-label="Cari supplier">
            </div>
            <div class="supplier-cards" id="supplierCards">
                @forelse($suppliers as $item)
                    <article class="supplier-card">
                        <header class="supplier-card-head">
                            <div class="supplier-avatar">{{ strtoupper(substr($item['nama'], 0, 1)) }}</div>
                            <div>
                                <h3>{{ $item['nama'] }}</h3>
                                <p>{{ $item['kontak'] ?: 'Kontak belum diisi' }}</p>
                            </div>
                        </header>
                        <div class="supplier-contact">
                            <p><span>Telepon</span>{{ $item['telepon'] ?: '-' }}</p>
                            <p><span>Email</span>{{ $item['email'] ?: '-' }}</p>
                        </div>
                        <p class="supplier-address"><strong>Alamat</strong><br>{{ $item['alamat'] ?: 'Alamat belum diisi' }}</p>
                        <footer class="supplier-card-footer">
                            <span class="supplier-secondary">Pemasok BakeChain</span>
                            <div class="supplier-row-actions">
                                <a href="{{ route('pemilik.supplier.edit', $item['id']) }}">Ubah</a>
                                <form action="{{ route('pemilik.supplier.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </div>
                        </footer>
                    </article>
                @empty
                    <p class="supplier-empty">Belum ada supplier. Tambahkan data pertama melalui formulir.</p>
                @endforelse
            </div>
            <p class="supplier-no-results" id="supplierNoResults">Supplier tidak ditemukan.</p>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('supplierSearch');
    const cards = Array.from(document.querySelectorAll('.supplier-card'));
    const empty = document.getElementById('supplierNoResults');

    search.addEventListener('input', function () {
        const query = search.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const matches = card.innerText.toLowerCase().includes(query);
            card.hidden = !matches;
            visible += matches ? 1 : 0;
        });

        empty.style.display = cards.length > 0 && visible === 0 ? 'block' : 'none';
    });
});
</script>
@endsection