@extends('pemilik.layout')

@section('title', 'Dashboard')

@section('content')
<style>
.dashboard-page {
    font-family: 'Inter', sans-serif;
    color:#292323;
}
.dashboard-banner {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    margin-bottom:18px;
    padding:22px 24px;
    background:#B60000;
    color:#fff;
    border-radius:0;
    box-shadow:0 8px 20px rgba(122,0,0,.12);
}
.dashboard-banner span {
    font-size:10px;
    font-weight:600;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#ffe3e3;
}
.dashboard-banner h2 {
    margin-top:5px;
    font-size:19px;
    font-weight:700;
}
.dashboard-banner p {
    margin-top:5px;
    color:#ffecec;
    font-size:11px;
}
.dashboard-banner-mark {
    width:50px;
    height:50px;
    display:grid;
    place-items:center;
    flex:none;
    border:1px solid #ffffff65;
    border-radius:0;
    font-size:21px;
    font-weight:700;
}
.stats {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:12px;
    margin-bottom:18px;
}
.stat {
    min-height:112px;
    padding:18px 17px;
    background:#fff;
    border:1px solid #efdada;
    border-top:3px solid #B60000;
    border-radius:0;
    box-shadow:0 4px 14px rgba(93,0,0,.04);
}
.stat p {
    font-size:11px;
    color:#756b6b;
    margin-bottom:11px;
}
.stat h3 {
    font-size:27px;
    color:#8C0000;
    line-height:1;
}
.panel {
    padding:19px;
    background:#fff;
    border:1px solid #efdada;
    border-radius:0;
    box-shadow:0 5px 18px rgba(93,0,0,.045);
    margin-bottom:18px;
}
.panel-heading h3 {
    color:#8C0000;
    font-size:14px;
    margin:0;
}
.panel-heading {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:18px;
}
.panel-heading a {
    font-size:11px;
    color:#8C0000;
    text-decoration:none;
    font-weight:600;
}
.btn-red {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:36px;
    background:#B60000;
    color:#fff;
    border:1px solid #B60000;
    border-radius:0;
    padding:0 14px;
    font:500 11px 'Inter',sans-serif;
    cursor:pointer;
}
.btn-red:hover {
    background:#8C0000;
}
.dashboard-notice {
    padding:11px 14px;
    margin-bottom:16px;
    background:#f2f8f1;
    border-left:3px solid #28652B;
    color:#28652B;
    font-size:12px;
}
.order-status {
    display:inline-block;
    padding:4px 7px;
    border:1px solid #e7b2b2;
    background:#fff5f5;
    color:#8C0000;
    font-size:10px;
    white-space:nowrap;
}
.table-wrap {
    overflow-x:auto;
}
.orders-table {
    width:100%;
    border-collapse:collapse;
    font-size:11px;
}
.orders-table th {
    padding:12px 10px;
    background:#fff2f2;
    text-align:left;
    font-weight:600;
    color:#625959;
}
.orders-table td {
    padding:16px 10px;
    border-bottom:1px solid #eee;
}
.empty-state {
    text-align:center;
    color:#777;
}
.bottom-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0 16px;
}
.stock-item {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:14px 0;
    border-bottom:1px solid #eee;
}
.stock-name {
    font-size:12px;
    font-weight:500;
}
.stock-description {
    font-size:10px;
    color:#777;
    margin-top:4px;
}
.stock-right {
    text-align:right;
}
.stock-number {
    font-size:13px;
    font-weight:600;
    color:#8C0000;
}
.stock-status {
    display:inline-block;
    margin-top:5px;
    padding:3px 7px;
    border:1px solid #e7b2b2;
    border-radius:0;
    background:#fff5f5;
    color:#8C0000;
    font-size:10px;
}
.stock-status.low {
    background:#8C0000;
    color:white;
}
.expiry-info {
    font-size:11px;
    line-height:1.7;
    color:#777;
    margin-top:16px;
}
/* Popup tambah pesanan */
.popup-overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(30,0,0,.5);
    z-index:99999;
    align-items:center;
    justify-content:center;
    padding:20px;
}
.popup-overlay.active {
    display:flex;
}
.popup-box {
    width:100%;
    max-width:520px;
    max-height:90vh;
    overflow-y:auto;
    background:#fff;
    padding:25px;
    border:1px solid #efdada;
    border-radius:0;
    box-shadow:0 15px 45px #0003;
}
.popup-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #e5dddd;
    padding-bottom:15px;
    margin-bottom:20px;
}
.popup-header h3 {
    font-size:18px;
    color:#8C0000;
}
.popup-close {
    border:0;
    background:none;
    font-size:27px;
    cursor:pointer;
    color:#777;
}
.popup-form label {
    display:block;
    font-size:12px;
    font-weight:500;
    margin-bottom:6px;
}
.popup-form input,.popup-form select,.popup-form textarea {
    width:100%;
    padding:10px;
    border:1px solid #e3d5d5;
    border-radius:0;
    margin-bottom:14px;
    font:12px 'Inter',sans-serif;
}
.popup-form input:focus,.popup-form select:focus,.popup-form textarea:focus {
    outline:1px solid #B60000;
}
.popup-error {
    margin:-9px 0 12px;
    color:#B60000;
    font-size:10px;
}
.popup-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:8px;
}
.btn-cancel {
    padding:10px 16px;
    background:white;
    border:1px solid #ddd;
    border-radius:0;
    font:12px 'Inter',sans-serif;
    cursor:pointer;
}
.popup-note {
    font-size:11px;
    color:#777;
}
@media(max-width:900px) {
    .stats {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .bottom-grid {
        grid-template-columns:1fr;
        gap:0;
    }
    .dashboard-banner {
        padding:19px;
    }
}
@media(max-width:500px) {
    .panel {
        padding:13px;
    }
    .stats {
        gap:8px;
    }
    .stat {
        min-height:100px;
        padding:14px 11px;
    }
    .stat h3 {
        font-size:23px;
    }
    .panel-heading {
        flex-wrap:wrap;
    }
    .popup-box {
        padding:18px;
    }
    .dashboard-banner {
        padding:17px;
    }
    .dashboard-banner h2 {
        font-size:16px;
    }
    .dashboard-banner-mark {
        width:40px;
        height:40px;
    }
}
</style>

<div class="dashboard-page">
    <div class="dashboard-banner">
        <div>
            <span>BAKECHAIN · PEMILIK UMKM</span>
            <h2>Selamat datang, {{ session('pemilik_nama', 'Pemilik BakeChain') }}</h2>
        </div>
    </div>

    <div class="stats">
        <div class="stat"><p>Total Pesanan</p><h3>{{ count($orders) }}</h3></div>
        <div class="stat"><p>Pesanan Diproses</p><h3>{{ collect($orders)->where('status', 'Diproses')->count() }}</h3></div>
        <div class="stat"><p>Jenis Bahan Baku</p><h3>0</h3></div>
        <div class="stat"><p>Produk Tersedia</p><h3>0</h3></div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h3>Pesanan Terbaru</h3>
            <div>
                <button type="button" class="btn-red" id="btnTambahPesanan">Tambah Pesanan Baru</button>
                <a href="#" style="margin-left:10px">Lihat semua</a>
            </div>
        </div>
        @if(session('success'))
            <div class="dashboard-notice">{{ session('success') }}</div>
        @endif
        <div class="table-wrap">
            <table class="orders-table">
                <thead><tr><th>No.</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse(array_slice(array_reverse($orders), 0, 5) as $index => $order)
                        <tr>
                            <td>{{ count($orders) - $index }}</td>
                            <td>{{ $order['pelanggan'] }}<small style="display:block;margin-top:4px;color:#777">{{ $order['produk'] }} · {{ $order['jumlah'] }} pcs</small></td>
                            <td>{{ \Illuminate\Support\Carbon::parse($order['tanggal'])->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format((float) $order['total'], 0, ',', '.') }}</td>
                            <td><span class="order-status">{{ $order['status'] }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">Belum ada pesanan yang masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="panel">
            <div class="panel-heading"><h3>Pemantauan Stok Bahan Baku</h3><a href="#">Lihat semua</a></div>
            <div class="stock-item"><div><div class="stock-name">Tepung Terigu</div><div class="stock-description">Bahan baku</div></div><div class="stock-right"><div class="stock-number">25 kg</div><span class="stock-status">Stok tersedia</span></div></div>
            <div class="stock-item"><div><div class="stock-name">Gula Pasir</div><div class="stock-description">Bahan baku</div></div><div class="stock-right"><div class="stock-number">12 kg</div><span class="stock-status">Stok tersedia</span></div></div>
            <div class="stock-item"><div><div class="stock-name">Mentega</div><div class="stock-description">Bahan baku</div></div><div class="stock-right"><div class="stock-number">3 kg</div><span class="stock-status low">Stok menipis</span></div></div>
        </div>
        <div class="panel">
            <div class="panel-heading"><h3>Pemantauan Kedaluwarsa</h3><a href="#">Lihat semua</a></div>
            <div class="stock-item"><div><div class="stock-name">Bahan Baku</div><div class="stock-description">Periksa tanggal kedaluwarsa bahan</div></div><div class="stock-right"><div class="stock-number">0</div><span class="stock-status">Perlu diperiksa</span></div></div>
            <p class="expiry-info">Informasi kedaluwarsa akan ditampilkan berdasarkan data batch bahan baku.</p>
        </div>
    </div>
</div>
</div>

<div class="popup-overlay {{ $errors->any() ? 'active' : '' }}" id="popupPesanan">
    <div class="popup-box" role="dialog" aria-modal="true" aria-labelledby="judulPopup">
        <div class="popup-header">
            <h3 id="judulPopup">Tambah Pesanan Baru</h3>
            <button type="button" class="popup-close" id="btnTutupPopup" aria-label="Tutup">&times;</button>
        </div>
        <form class="popup-form" id="formPesanan" action="{{ route('pemilik.pesanan.store') }}" method="POST">
            @csrf
            <label for="pelanggan">Nama Pelanggan</label>
            <input id="pelanggan" name="pelanggan" type="text" maxlength="100" value="{{ old('pelanggan') }}" placeholder="Masukkan nama pelanggan" required>
            @error('pelanggan')<p class="popup-error">{{ $message }}</p>@enderror

            <label for="tanggal">Tanggal Pengambilan</label>
            <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal') }}" required>
            @error('tanggal')<p class="popup-error">{{ $message }}</p>@enderror

            <label for="produk">Produk Bakery</label>
            <select id="produk" name="produk" required>
                <option value="">Pilih produk</option>
                @foreach(['Roti Cokelat','Roti Keju','Brownies','Kue Bolu'] as $produk)
                    <option value="{{ $produk }}" @selected(old('produk') === $produk)>{{ $produk }}</option>
                @endforeach
            </select>
            @error('produk')<p class="popup-error">{{ $message }}</p>@enderror

            <label for="jumlah">Jumlah Pesanan (pcs)</label>
            <input id="jumlah" name="jumlah" type="number" min="1" max="99999" step="1" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" required>
            @error('jumlah')<p class="popup-error">{{ $message }}</p>@enderror

            <label for="total">Total Harga (Rp)</label>
            <input id="total" name="total" type="number" min="0" max="999999999" step="1" value="{{ old('total') }}" placeholder="Masukkan total harga" required>
            @error('total')<p class="popup-error">{{ $message }}</p>@enderror

            <label for="catatan">Catatan (opsional)</label>
            <textarea id="catatan" name="catatan" rows="2" maxlength="255" placeholder="Catatan tambahan">{{ old('catatan') }}</textarea>
            @error('catatan')<p class="popup-error">{{ $message }}</p>@enderror

            <p class="popup-note">Pesanan disimpan sementara dalam sesi ini.</p>
            <div class="popup-actions">
                <button type="button" class="btn-cancel" id="btnBatalPopup">Batal</button>
                <button type="submit" class="btn-red">Simpan Pesanan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popupPesanan');

    document.getElementById('btnTambahPesanan').addEventListener('click', function () {
        popup.classList.add('active');
        document.getElementById('pelanggan').focus();
    });

    function tutupPopup() {
        popup.classList.remove('active');
    }

    document.getElementById('btnTutupPopup').addEventListener('click', tutupPopup);
    document.getElementById('btnBatalPopup').addEventListener('click', tutupPopup);

    popup.addEventListener('click', function (event) {
        if (event.target === popup) tutupPopup();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') tutupPopup();
    });

});
</script>
@endsection