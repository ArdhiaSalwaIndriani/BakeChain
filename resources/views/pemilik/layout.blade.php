
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Dashboard') | BakeChain</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

body{
    font-family: 'Inter', sans-serif;
    background:#fff8f8;
    color:#302727;
    font-size:13px;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    inset:0 auto 0 0;
    width:240px;
    background:#fff;
    border-right:1px solid #f0dddd;
    padding:25px 16px;
    display:flex;
    flex-direction:column;
    overflow-y:auto;
    box-shadow:4px 0 18px rgba(93,0,0,.035);
}

.brand{
    font-size:24px;
    font-weight:700;
    color:#B60000;
    padding:0 10px;
    margin-bottom:12px;
    padding-bottom:15px;
    border-bottom:1px solid #f3e2e2;
}

.brand span{color:#e6a4a4}

.section-title{
    font-size:10px;
    font-weight:600;
    letter-spacing:.8px;
    color:#8C0000;
    background:#fff3f3;
    border-left:3px solid #B60000;
    padding:10px 12px;
    margin:8px 0;
}

.menu-link,.logout-btn{
    display:flex;
    gap:12px;
    align-items:center;
    width:100%;
    padding:11px 12px;
    margin-bottom:3px;
    border:0;
    background:transparent;
    color:#625959;
    text-decoration:none;
    text-align:left;
    font:400 12px 'Inter',sans-serif;
    cursor:pointer;
    transition:background .2s,color .2s;
}

.menu-link:hover,
.menu-link.active,
.logout-btn:hover{
    background:#fff0f0;
    color:#B60000;
}

.menu-link.active{
    font-weight:700;
    border-left:3px solid #B60000;
}

.menu-icon{
    width:17px;
    text-align:center;
    flex-shrink:0;
}

.sidebar-bottom{
    margin-top:auto;
    border-top:1px solid #e5dede;
    padding-top:12px;
}

/* MAIN CONTENT */
.main{
    margin-left:240px;
    padding:27px 30px;
    min-height:100vh;
    background:linear-gradient(180deg,#fffafa 0,#fff8f8 260px,#fff8f8 100%);
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:27px;
    padding-bottom:20px;
    border-bottom:1px solid #efdada;
}

.topbar-title{
    border-left:4px solid #B60000;
    padding:3px 0 3px 12px;
}

.topbar h1{
    font-size:22px;
    font-weight:700;
}

.topbar p{
    font-size:11px;
    color:#756b6b;
    margin-top:5px;
}

.content{min-width:0}

/* PROFILE DROPDOWN */
.profile-wrap{
    position:relative;
    flex-shrink:0;
}

.profile{
    display:flex;
    align-items:center;
    gap:11px;
    min-width:208px;
    min-height:58px;
    padding:9px 12px;
    background:#fff;
    border:1px solid #e7caca;
    border-radius:16px;
    cursor:pointer;
    text-align:left;
    font-family: 'Inter', sans-serif;
    color:#302727;
    transition:background .2s,border-color .2s,box-shadow .2s;
}

.profile:hover,
.profile[aria-expanded="true"]{
    border-color:#B60000;
    background:#fffafa;
    box-shadow:0 3px 9px #B6000018;
}

.avatar{
    width:36px;
    height:36px;
    flex-shrink:0;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#B60000;
    color:#fff;
    border-radius:16px;
    font-size:14px;
    font-weight:800;
}

.profile > span:nth-child(2){
    display:flex;
    flex-direction:column;
    flex:1;
    min-width:0;
    gap:3px;
}

.profile-name{
    display:block;
    font-size:12px;
    font-weight:800;
    line-height:1.4;
    color:#241b1b;
    overflow-wrap:anywhere;
}

.profile-role{
    display:block;
    font-size:10px;
    font-weight:600;
    line-height:1.4;
    color:#625959;
}

.profile-arrow {
    flex-shrink: 0;
    margin-left: 0;
    position: relative;
    left: -8px;
    top: -5px;
    color: #B60000;
    font-size: 16px;
    font-weight: 800;
    transition: transform .2s;
}

.profile[aria-expanded="true"] .profile-arrow{
    transform:rotate(180deg);
}

/* ISI DROPDOWN */
.profile-menu{
    display:none;
    position:absolute;
    right:0;
    top:calc(100% + 8px);
    width:250px;
    background:#fff;
    border:1px solid #efdada;
    border-radius:16px;
    box-shadow:0 12px 30px #00000018;
    overflow:hidden;
    z-index:1000;
}

.profile-menu.open{display:block}

.profile-summary{
    padding:16px;
    border-bottom:1px solid #eee;
    overflow-wrap:anywhere;
}

.profile-summary strong{
    display:block;
    font-size:13px;
    font-weight:800;
    color:#302727;
}

.profile-summary small{
    display:block;
    color:#625959;
    font-size:11px;
    font-weight:500;
    margin-top:5px;
}

.profile-item{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
    padding:12px 16px;
    background:#fff;
    color:#493e3e;
    text-decoration:none;
    font:500 12px 'Inter',sans-serif;
    border:0;
    cursor:pointer;
}

.profile-item:hover{
    background:#fff0f0;
    color:#B60000;
}

.profile-logout{
    border-top:1px solid #eee;
    color:#B60000;
}

/* TABLET */
@media(max-width:750px){
    .sidebar{
        width:190px;
        padding:20px 10px;
    }

    .main{
        margin-left:190px;
        padding:20px 14px;
    }

    .topbar h1{font-size:19px}

    .profile{
        min-width:0;
        padding:7px 9px;
        gap:8px;
    }

    .profile-arrow{
        display:block;
        margin-left:0;
    }
}

/* MOBILE */
@media(max-width:520px){
    .sidebar{
        width:62px;
        padding:20px 6px;
    }

    .brand{
        font-size:0;
        padding:5px 10px 0;
        margin-bottom:30px;
    }

    .brand:after{
        content:'B.';
        font-size:23px;
    }

    .section-title{
        font-size:0;
        padding:7px;
    }

    .menu-link{
        justify-content:center;
        font-size:0;
        padding:12px 4px;
    }

    .menu-icon{font-size:15px}

    .logout-btn{
        justify-content:center;
        font-size:0;
    }

    .main{
        margin-left:62px;
        padding:15px 10px;
    }

    .topbar{
        gap:8px;
    }

    .topbar h1{font-size:16px}

    .topbar p{font-size:10px}

    .profile{
        min-width:0;
        min-height:48px;
        padding:5px;
        gap:6px;
        border-width:1px;
    }

    .avatar{
        width:32px;
        height:32px;
    }

    .profile-name,
    .profile-role{
        display:none;
    }

    .profile-arrow{
        display:block;
        font-size:14px;
    }

    .profile-menu{
        right:0;
        width:220px;
    }

    
/* Posisi dropdown profil */
.profile-wrap{
    margin-top:-15px;
    margin-right:0;
}

.profile{
    min-width:0;
}
}
</style>
    <link rel="stylesheet" href="{{ asset('css/bakechain-ui.css') }}">

<style id="bakechain-professional-ui">
html,body,button,input,select,textarea,*{font-family:'Inter',sans-serif!important}body{font-size:15px!important;line-height:1.6!important;color:#202938!important;background:#f5f7fa!important}.sidebar{background:#fff!important;border-right:1px solid #e6e9ef!important;box-shadow:0 0 24px #17203308!important}.brand{color:#a91d2a!important}.section-title{background:transparent!important;border:0!important;color:#7b8493!important;border-radius:12px!important}.menu-link,.logout-btn{font-family:'Inter',sans-serif!important;font-size:14px!important;border-radius:12px!important}.menu-link.active{border:0!important;background:#fff1f2!important;color:#a91d2a!important}.main{background:#f5f7fa!important}.topbar-title{border:0!important;padding-left:0!important}.topbar h1{font-size:clamp(25px,2vw,32px)!important;color:#202938!important}.topbar p{font-size:14px!important;color:#667085!important}.dashboard-page,.admin-dashboard,.customer-dashboard{font-family:'Inter',sans-serif!important;color:#202938!important}.dashboard-banner,.admin-banner,.customer-banner{border-radius:22px!important;background:linear-gradient(115deg,#8f1824,#b82b37)!important;padding:28px 30px!important;box-shadow:0 12px 30px #941e2b1a!important}.dashboard-banner h2,.admin-banner h2,.customer-banner h2{font-size:24px!important}.stats,.admin-stats,.customer-stats{gap:18px!important}.stat,.admin-stat,.customer-stat,.panel,.admin-panel,.customer-panel,.dashboard-card,.card,.form-card,.summary-card,.chart-card{border:1px solid #e6e9ef!important;border-top:1px solid #e6e9ef!important;border-radius:20px!important;box-shadow:0 5px 20px #18223007!important;background:#fff!important}.stat,.admin-stat,.customer-stat{padding:22px!important;min-height:128px!important}.stat p,.admin-stat p,.customer-stat p{font-size:13px!important;color:#667085!important}.stat h3,.admin-stat h3,.customer-stat h3{font-size:32px!important;color:#202938!important}.panel,.admin-panel,.customer-panel{padding:24px!important}.panel-heading h3,.admin-panel-heading h3,.customer-panel-heading h3{font-size:17px!important;color:#202938!important}.btn-red,.btn,.button,button{border-radius:12px!important;font-family:'Inter',sans-serif!important;font-size:14px!important}.order-status,.badge{border:0!important;border-radius:999px!important;padding:6px 10px!important;font-size:12px!important}table{font-size:14px!important}th{font-size:12px!important;background:#f8f9fb!important;color:#667085!important}td,th{padding:14px 13px!important;border-color:#edf0f4!important}input,select,textarea{border-radius:12px!important;font-size:14px!important;min-height:44px}@media(max-width:900px){.stats,.admin-stats,.customer-stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}}@media(max-width:560px){.stats,.admin-stats,.customer-stats{grid-template-columns:1fr!important}.dashboard-banner,.admin-banner,.customer-banner{padding:22px!important}}
</style>
</head>

<body>
<button class="mobile-menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="appSidebar">☰</button>
<div class="sidebar-overlay" data-sidebar-close></div>

<aside class="sidebar" id="appSidebar">
    <div class="brand">BakeChain<span>.</span></div>

    <div class="section-title">MENU UTAMA</div>

    <a class="menu-link {{ request()->routeIs('pemilik.dashboard')?'active':'' }}"
       href="{{ route('pemilik.dashboard') }}">
        <span class="menu-icon">▦</span>Dashboard
    </a>

    <div class="section-title">MANAJEMEN USAHA</div>

    @foreach(['Supplier','Bahan Baku','Pembelian','Penerimaan Bahan','Batch & Kedaluwarsa','Stok Bahan','Produksi','Produk Bakery','Pre-Order','Laporan'] as $i => $item)
        @php
            $itemRoute = match ($item) {
                'Supplier' => 'pemilik.supplier.index',
                'Bahan Baku' => 'pemilik.bahan-baku.index',
                'Pembelian' => 'pemilik.pembelian.index',
                'Penerimaan Bahan' => 'pemilik.penerimaan.index',
                'Batch & Kedaluwarsa' => 'pemilik.batch.index',
                default => null,
            };
            $itemActive = $itemRoute && request()->routeIs(
                match ($item) {
                    'Supplier' => 'pemilik.supplier.*',
                    'Bahan Baku' => 'pemilik.bahan-baku.*',
                    'Pembelian' => 'pemilik.pembelian.*',
                    'Penerimaan Bahan' => 'pemilik.penerimaan.*',
                    default => 'pemilik.batch.*',
                }
            );
        @endphp
        <a class="menu-link {{ $itemActive ? 'active' : '' }}"
           href="{{ $itemRoute ? route($itemRoute) : '#' }}">
            <span class="menu-icon">{{ sprintf('%02d',$i+1) }}</span>{{ $item }}
        </a>
    @endforeach

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <span class="menu-icon">↪</span>Logout
            </button>
        </form>
    </div>
</aside>

<main class="main">
    <header class="topbar">
        <div class="topbar-title">
            <h1>@yield('heading','Dashboard')</h1>
            <p>@yield('subtitle', 'Ringkasan operasional usaha bakery')</p>
        </div>

        <div class="profile-wrap" id="profileWrap">
            <button
                type="button"
                class="profile"
                id="profileButton"
                aria-expanded="false"
                aria-controls="profileMenu"
            >
                <span class="avatar">{{ strtoupper(substr(session('pemilik_nama','Pemilik BakeChain'),0,1)) }}</span>

                <span>
                    <span class="profile-name">{{ session('pemilik_nama','Pemilik BakeChain') }}</span>
                    <span class="profile-role">Pemilik UMKM</span>
                </span>

                <span class="profile-arrow">⌄</span>
            </button>

            <div class="profile-menu" id="profileMenu">
                <div class="profile-summary">
                    <strong>{{ session('pemilik_nama','Pemilik BakeChain') }}</strong>
                    <small>{{ session('pemilik_email','pemilik@bakechain.com') }}</small>
                    <small>Pemilik UMKM</small>
                </div>

                <a class="profile-item" href="{{ route('pemilik.profil') }}">
                    ♙ <span>Profil Saya</span>
                </a>

                <a class="profile-item" href="{{ route('pemilik.pengaturan') }}">
                    ⚙ <span>Pengaturan Akun</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="profile-item profile-logout" type="submit">
                        ↪ <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <section class="content">
        @yield('content')
    </section>
</main>

<style>
.pemilik-rounded-panel,
.supplier-form-panel,
.supplier-directory,
.materials-form,
.materials-directory,
.purchase-form,
.purchase-board,
.receiving-panel,
.batch-form,
.batch-board,
.dashboard-banner,
.stat,
.panel {
    border-radius: 20px;
    overflow: hidden;
}

.section-title {
    border-radius: 12px;
}

.profile,
.profile-menu {
    border-radius: 16px;
}

.avatar,
.dashboard-banner-mark,
.supplier-avatar {
    border-radius: 12px;
}

.supplier-field input,
.supplier-field textarea,
.supplier-search,
.materials-field input,
.materials-field select,
.materials-field textarea,
.materials-search,
.purchase-field input,
.purchase-field select,
.purchase-field textarea,
.receiving-field input,
.receiving-field select,
.receiving-field textarea,
.batch-field input,
.batch-field select,
.batch-field textarea,
.receiving-search,
.popup-form input,
.popup-form select,
.popup-form textarea {
    border-radius: 12px;
}

.supplier-button,
.supplier-cancel,
.supplier-row-actions a,
.supplier-row-actions button,
.materials-button,
.materials-cancel,
.materials-row-actions a,
.materials-row-actions button,
.purchase-button,
.purchase-cancel,
.purchase-row-actions a,
.purchase-row-actions button,
.receiving-button,
.receiving-cancel,
.receiving-row-actions a,
.receiving-row-actions button,
.batch-button,
.batch-cancel,
.batch-row-actions a,
.batch-row-actions button,
.btn-red,
.btn-cancel {
    border-radius: 11px;
}

.supplier-card,
.purchase-order,
.receiving-queue-item,
.batch-card {
    border-radius: 16px;
}

.supplier-notice,
.materials-notice,
.purchase-notice,
.purchase-warning,
.receiving-notice,
.receiving-warning,
.batch-notice,
.batch-warning {
    border-radius: 12px;
}

.supplier-card-head,
.materials-list-head,
.purchase-board-head,
.receiving-list-head,
.batch-board-head {
    border-top-left-radius: 18px;
    border-top-right-radius: 18px;
}

.materials-summary,
.purchase-summary,
.batch-summary {
    border-radius: 18px;
    overflow: hidden;
}

.materials-summary-item:last-child,
.purchase-summary-item:last-child,
.batch-summary-item:last-child {
    border-bottom-right-radius: 18px;
}

.order-status,
.stock-status,
.batch-state,
.purchase-status,
.receiving-progress-label {
    border-radius: 999px;
}

.table-wrap,
.materials-table-wrap,
.receiving-table-wrap {
    border-radius: 16px;
    overflow: hidden;
}

.popup-box {
    border-radius: 22px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrap = document.getElementById('profileWrap');
    const button = document.getElementById('profileButton');
    const menu = document.getElementById('profileMenu');

    button.addEventListener('click', function () {
        const open = menu.classList.toggle('open');
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    document.addEventListener('click', function (event) {
        if (!wrap.contains(event.target)) {
            menu.classList.remove('open');
            button.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            menu.classList.remove('open');
            button.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded',function(){const toggle=document.querySelector('.mobile-menu-toggle');const overlay=document.querySelector('[data-sidebar-close]');const sidebar=document.querySelector('.sidebar');function closeMenu(){document.body.classList.remove('sidebar-open');if(toggle)toggle.setAttribute('aria-expanded','false')}if(toggle){toggle.addEventListener('click',function(){const open=document.body.classList.toggle('sidebar-open');toggle.setAttribute('aria-expanded',String(open));toggle.textContent=open?'×':'☰'})}if(overlay)overlay.addEventListener('click',closeMenu);document.addEventListener('keydown',function(e){if(e.key==='Escape')closeMenu()});if(sidebar)sidebar.querySelectorAll('a').forEach(function(a){a.addEventListener('click',function(){if(window.innerWidth<=700)closeMenu()})});window.addEventListener('resize',function(){if(window.innerWidth>700)closeMenu()})});
</script>
</body>
</html>
