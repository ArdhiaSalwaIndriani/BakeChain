<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | BakeChain Supplier</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/bakechain-ui.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff8f8;
            color: #302727;
            font-size: 13px;
        }

        a {
            color: inherit;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 240px;
            background: #fff;
            border-right: 1px solid #f0dddd;
            padding: 25px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 4px 0 18px rgba(93, 0, 0, 0.035);
        }

        .brand {
            font-size: 24px;
            font-weight: 700;
            color: #B60000;
            padding: 0 10px 15px;
            margin-bottom: 12px;
            border-bottom: 1px solid #f3e2e2;
        }

        .brand span {
            color: #e6a4a4;
        }

        .section-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.8px;
            color: #8C0000;
            background: #fff3f3;
            border-left: 3px solid #B60000;
            padding: 10px 12px;
            margin: 8px 0;
        }

        .menu-link,
        .logout-btn {
            display: flex;
            gap: 12px;
            align-items: center;
            width: 100%;
            padding: 11px 12px;
            margin-bottom: 3px;
            border: 0;
            background: transparent;
            color: #625959;
            text-decoration: none;
            text-align: left;
            font: 400 12px 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .menu-link:hover,
        .menu-link.active,
        .logout-btn:hover {
            background: #fff0f0;
            color: #B60000;
        }

        .menu-link.active {
            font-weight: 700;
            border-left: 3px solid #B60000;
        }

        .menu-icon {
            width: 17px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid #e5dede;
            padding-top: 12px;
        }

        .main {
            margin-left: 240px;
            padding: 27px 30px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #efdada;
        }

        .topbar-title {
            border-left: 4px solid #B60000;
            padding: 3px 0 3px 12px;
        }

        .topbar h1 {
            font-size: 22px;
            font-weight: 700;
        }

        .topbar p {
            font-size: 11px;
            color: #756b6b;
            margin-top: 5px;
        }

        .content {
            min-width: 0;
        }

        .profile-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 220px;
            max-width: 300px;
            min-height: 58px;
            padding: 9px 12px;
            background: #fff;
            border: 1px solid #e7caca;
            cursor: pointer;
            text-align: left;
            font-family: 'Inter', sans-serif;
            color: #302727;
        }

        .profile:hover,
        .profile[aria-expanded="true"] {
            border-color: #B60000;
            background: #fffafa;
        }

        .avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 14px;
            background: #a91d2a;
            color: #fff;
            font-size: 14px;
            font-weight: 800;
        }

        .avatar img,
        .profile-summary-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-fallback {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: #a91d2a;
            color: #fff;
            font-weight: 800;
        }

        .profile-text {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 3px;
            min-width: 0;
        }

        .profile-name {
            max-width: 190px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 12px;
            font-weight: 800;
        }

        .profile-role {
            font-size: 10px;
            font-weight: 600;
            color: #625959;
        }

        .profile-arrow {
            color: #B60000;
            font-size: 16px;
            font-weight: 800;
        }

        .profile-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 1000;
            width: 250px;
            max-width: calc(100vw - 24px);
            background: #fff;
            border: 1px solid #efdada;
            box-shadow: 0 12px 30px #00000018;
        }

        .profile-menu.open {
            display: block;
        }

        .profile-summary {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid #eee;
        }

        .profile-summary-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 48px;
            width: 48px;
            height: 48px;
            overflow: hidden;
            border-radius: 14px;
            background: #a91d2a;
            color: #fff;
            font-weight: 800;
        }

        .profile-summary-text {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .profile-summary-text strong {
            display: block;
            overflow-wrap: anywhere;
            font-size: 13px;
            font-weight: 800;
        }

        .profile-summary-text small {
            display: block;
            margin-top: 5px;
            color: #625959;
            font-size: 11px;
        }

        .profile-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border: 0;
            background: #fff;
            color: #B60000;
            text-decoration: none;
            font: 500 12px 'Inter', sans-serif;
            cursor: pointer;
        }

        .profile-item:hover {
            background: #fff0f0;
        }

        .banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 18px;
            padding: 22px 24px;
            border-radius: 20px;
            background: #B60000;
            color: #fff;
            box-shadow: 0 8px 20px rgba(122, 0, 0, 0.12);
        }

        .banner span {
            color: #ffe3e3;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .banner h2 {
            margin-top: 5px;
            font-size: 19px;
            font-weight: 700;
        }

        .banner p {
            margin-top: 5px;
            color: #ffecec;
            font-size: 11px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat {
            min-height: 100px;
            padding: 17px;
            border: 1px solid #efdada;
            border-top: 3px solid #B60000;
            background: #fff;
            box-shadow: 0 4px 14px rgba(93, 0, 0, 0.04);
        }

        .stat p {
            margin-bottom: 10px;
            color: #756b6b;
            font-size: 11px;
        }

        .stat h3 {
            color: #8C0000;
            font-size: 26px;
            line-height: 1;
        }

        .panel {
            min-width: 0;
            margin-bottom: 18px;
            padding: 19px;
            border: 1px solid #efdada;
            background: #fff;
            box-shadow: 0 5px 18px rgba(93, 0, 0, 0.045);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .panel-heading h3 {
            color: #8C0000;
            font-size: 14px;
        }

        .panel-heading a {
            color: #8C0000;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 16px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th {
            padding: 12px 10px;
            background: #fff2f2;
            color: #625959;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        td small {
            display: block;
            margin-top: 3px;
            color: #756b6b;
            font-size: 10px;
        }

        .empty {
            padding: 26px !important;
            color: #777;
            text-align: center;
        }

        .link {
            color: #B60000;
            font-weight: 600;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border: 1px solid #e7b2b2;
            background: #fff5f5;
            color: #8C0000;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .st-direncanakan {
            border-color: #d8d8d8;
            background: #f4f4f4;
            color: #555;
        }

        .st-diproses,
        .st-disiapkan {
            border-color: #e8d39b;
            background: #fff9e9;
            color: #8a5a00;
        }

        .st-dikirim {
            border-color: #b9cdf0;
            background: #eef4ff;
            color: #1d4a9a;
        }

        .st-diterima,
        .st-tersedia {
            border-color: #d9e6d7;
            background: #f3f8f2;
            color: #28652B;
        }

        .st-dibatalkan,
        .st-kadaluarsa,
        .st-habis {
            border-color: #e7b2b2;
            background: #fff0f0;
            color: #B60000;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: 1px solid #B60000;
            background: #B60000;
            color: #fff;
            font: 600 11px 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #8C0000;
        }

        .btn-light {
            background: #fff;
            color: #B60000;
        }

        .btn-light:hover {
            background: #fff0f0;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 10px;
            margin-bottom: 16px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 0;
        }

        .field label {
            color: #625959;
            font-size: 10px;
            font-weight: 600;
        }

        .field input,
        .field select,
        .field textarea {
            min-width: 160px;
            padding: 9px 10px;
            border: 1px solid #e0c9c9;
            background: #fff;
            color: #302727;
            font: 400 12px 'Inter', sans-serif;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: 0;
            border-color: #B60000;
        }

        .field-error {
            color: #B60000;
            font-size: 10px;
        }

        .alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border: 1px solid;
            font-size: 12px;
        }

        .alert-success {
            border-color: #bcd9b8;
            background: #f3f8f2;
            color: #28652B;
        }

        .alert-error {
            border-color: #e7b2b2;
            background: #fff0f0;
            color: #8C0000;
        }

        .alert ul {
            margin-left: 16px;
        }

        .kv {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px 14px;
            font-size: 12px;
        }

        .kv dt {
            color: #756b6b;
        }

        .kv dd {
            overflow-wrap: anywhere;
            font-weight: 500;
        }

        .steps {
            display: flex;
            gap: 0;
            margin-bottom: 18px;
        }

        .step {
            flex: 1;
            padding: 10px;
            border-right: 2px solid #fff;
            background: #f4f4f4;
            color: #888;
            font-size: 10px;
            font-weight: 600;
            text-align: center;
        }

        .step.done {
            background: #f3f8f2;
            color: #28652B;
        }

        .step.now {
            background: #B60000;
            color: #fff;
        }

        .pager {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 14px;
            color: #756b6b;
            font-size: 11px;
        }

        .pager a {
            padding: 7px 12px;
            border: 1px solid #B60000;
            color: #B60000;
            font-weight: 600;
            text-decoration: none;
        }

        .pager a:hover {
            background: #fff0f0;
        }

        .mobile-menu-toggle,
        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 1000px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .main {
                padding: 22px 18px;
            }

            .topbar {
                align-items: flex-start;
            }

            .profile {
                min-width: 0;
                max-width: 220px;
            }

            .stats {
                gap: 18px;
            }
        }

        @media (max-width: 750px) {
            .sidebar {
                width: 190px;
                padding: 20px 10px;
            }

            .main {
                margin-left: 190px;
                padding: 20px 14px;
            }

            .profile {
                min-width: 0;
            }
        }

        @media (max-width: 700px) {
            .mobile-menu-toggle {
                position: fixed;
                top: 12px;
                left: 12px;
                z-index: 1200;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                border: 1px solid #e6e9ef;
                border-radius: 12px;
                background: #fff;
                color: #a91d2a;
                font-size: 21px;
                cursor: pointer;
                box-shadow: 0 4px 14px #17203312;
            }

            .sidebar {
                z-index: 1100;
                width: 250px;
                padding: 20px 14px;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                z-index: 1050;
                background: rgba(17, 24, 39, 0.38);
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            .brand {
                margin-bottom: 12px;
                padding: 0 10px 15px;
                font-size: 24px;
            }

            .section-title {
                padding: 10px 12px;
                border-left: 3px solid #B60000;
                background: #fff3f3;
                font-size: 10px;
            }

            .menu-link,
            .logout-btn {
                justify-content: flex-start;
                padding: 11px 12px;
                font-size: 12px;
            }

            .menu-icon {
                font-size: 15px;
            }

            .main {
                margin-left: 0;
                padding: 70px 14px 20px;
            }

            .topbar {
                flex-wrap: wrap;
                gap: 14px;
            }

            .topbar h1 {
                font-size: 21px;
            }

            .profile-wrap {
                margin-left: auto;
            }

            .profile {
                max-width: 220px;
            }

            .profile-name {
                max-width: 125px;
            }

            .kv {
                grid-template-columns: 1fr;
            }

            .steps {
                flex-direction: column;
            }
        }

        @media (max-width: 560px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .banner {
                padding: 22px;
                border-radius: 18px;
            }

            .banner h2 {
                font-size: 21px;
            }

            .panel {
                padding: 16px;
            }

            .panel-heading {
                align-items: flex-start;
            }

            .topbar h1 {
                font-size: 19px;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 12px 10px;
            }

            .profile {
                min-height: 48px;
                padding: 5px;
                gap: 6px;
            }

            .profile-name,
            .profile-role {
                display: block;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }

        html,
        body,
        button,
        input,
        select,
        textarea,
        * {
            font-family: 'Inter', sans-serif !important;
        }

        body {
            background: #f5f7fa !important;
            color: #202938 !important;
            font-size: 15px !important;
            line-height: 1.6 !important;
        }

        .sidebar {
            background: #fff !important;
            border-right: 1px solid #e6e9ef !important;
            box-shadow: 0 0 24px #17203308 !important;
        }

        .brand {
            color: #a91d2a !important;
        }

        .section-title {
            border: 0 !important;
            border-radius: 12px !important;
            background: transparent !important;
            color: #7b8493 !important;
        }

        .menu-link,
        .logout-btn {
            border-radius: 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
        }

        .menu-link.active {
            border: 0 !important;
            background: #fff1f2 !important;
            color: #a91d2a !important;
        }

        .main {
            background: #f5f7fa !important;
        }

        .topbar-title {
            padding-left: 0 !important;
            border: 0 !important;
        }

        .topbar h1 {
            color: #202938 !important;
            font-size: clamp(25px, 2vw, 32px) !important;
        }

        .topbar p {
            color: #667085 !important;
            font-size: 14px !important;
        }

        .dashboard-page,
        .admin-dashboard,
        .customer-dashboard {
            color: #202938 !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dashboard-banner,
        .admin-banner,
        .customer-banner {
            padding: 28px 30px !important;
            border-radius: 22px !important;
            background: linear-gradient(115deg, #8f1824, #b82b37) !important;
            box-shadow: 0 12px 30px #941e2b1a !important;
        }

        .dashboard-banner h2,
        .admin-banner h2,
        .customer-banner h2 {
            font-size: 24px !important;
        }

        .stats,
        .admin-stats,
        .customer-stats {
            gap: 18px !important;
        }

        .stat,
        .admin-stat,
        .customer-stat,
        .panel,
        .admin-panel,
        .customer-panel,
        .dashboard-card,
        .card,
        .form-card,
        .summary-card,
        .chart-card {
            border: 1px solid #e6e9ef !important;
            border-radius: 20px !important;
            background: #fff !important;
            box-shadow: 0 5px 20px #18223007 !important;
        }

        .stat,
        .admin-stat,
        .customer-stat {
            min-height: 128px !important;
            padding: 22px !important;
        }

        .stat p,
        .admin-stat p,
        .customer-stat p {
            color: #667085 !important;
            font-size: 13px !important;
        }

        .stat h3,
        .admin-stat h3,
        .customer-stat h3 {
            color: #202938 !important;
            font-size: 32px !important;
        }

        .panel,
        .admin-panel,
        .customer-panel {
            padding: 24px !important;
        }

        .panel-heading h3,
        .admin-panel-heading h3,
        .customer-panel-heading h3 {
            color: #202938 !important;
            font-size: 17px !important;
        }

        .btn-red,
        .btn,
        .button,
        button {
            border-radius: 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
        }

        .order-status,
        .badge {
            padding: 6px 10px !important;
            border: 0 !important;
            border-radius: 999px !important;
            font-size: 12px !important;
        }

        table {
            font-size: 14px !important;
        }

        th {
            background: #f8f9fb !important;
            color: #667085 !important;
            font-size: 12px !important;
        }

        td,
        th {
            padding: 14px 13px !important;
            border-color: #edf0f4 !important;
        }

        input,
        select,
        textarea {
            min-height: 44px;
            border-radius: 12px !important;
            font-size: 14px !important;
        }

        @media (max-width: 900px) {
            .stats,
            .admin-stats,
            .customer-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 560px) {
            .stats,
            .admin-stats,
            .customer-stats {
                grid-template-columns: 1fr !important;
            }

            .dashboard-banner,
            .admin-banner,
            .customer-banner {
                padding: 22px !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <button
        class="mobile-menu-toggle"
        type="button"
        aria-label="Buka navigasi"
        aria-expanded="false"
        aria-controls="appSidebar"
    >
        ☰
    </button>

    <div class="sidebar-overlay" data-sidebar-close></div>

    @php
        $supplierUser = auth()->user();

        $supplierPhoto = $supplierUser && $supplierUser->profile_photo_path
            ? asset('storage/' . $supplierUser->profile_photo_path)
            : null;

        $supplierInitial = $supplierUser
            ? mb_strtoupper(mb_substr(trim($supplierUser->name), 0, 1))
            : 'S';
    @endphp

    <aside class="sidebar" id="appSidebar">
        <div class="brand">BakeChain<span>.</span></div>

        <div class="section-title">MENU UTAMA</div>

        <a
            class="menu-link {{ request()->routeIs('supplier.dashboard') ? 'active' : '' }}"
            href="{{ route('supplier.dashboard') }}"
        >
            <span class="menu-icon">▦</span>
            Dashboard
        </a>

        <a
            class="menu-link {{ request()->routeIs('supplier.permintaan*') ? 'active' : '' }}"
            href="{{ route('supplier.permintaan') }}"
        >
            <span class="menu-icon">☰</span>
            Permintaan Bahan
        </a>

        <div class="section-title">PENGIRIMAN</div>

        <a
            class="menu-link {{ request()->routeIs('supplier.riwayat') ? 'active' : '' }}"
            href="{{ route('supplier.riwayat') }}"
        >
            <span class="menu-icon">➜</span>
            Riwayat Pengiriman
        </a>

        <a
            class="menu-link {{ request()->routeIs('supplier.batch') ? 'active' : '' }}"
            href="{{ route('supplier.batch') }}"
        >
            <span class="menu-icon">◫</span>
            Informasi Batch
        </a>

        <div class="section-title">AKUN</div>

        <a
            class="menu-link {{ request()->routeIs('supplier.profil') ? 'active' : '' }}"
            href="{{ route('supplier.profil') }}"
        >
            <span class="menu-icon">♙</span>
            Profil Supplier
        </a>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-btn">
                    <span class="menu-icon">↪</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-title">
                <h1>@yield('heading', 'Dashboard Supplier')</h1>
            </div>

            <div class="profile-wrap" id="profileWrap">
                <button
                    type="button"
                    class="profile"
                    id="profileButton"
                    aria-expanded="false"
                    aria-controls="profileMenu"
                >
                    <span class="avatar">
                        @if ($supplierPhoto)
                            <img
                                src="{{ $supplierPhoto }}"
                                alt="Foto profil {{ $supplierUser->name }}"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                            >

                            <span class="avatar-fallback" style="display: none">
                                {{ $supplierInitial }}
                            </span>
                        @else
                            <span class="avatar-fallback">
                                {{ $supplierInitial }}
                            </span>
                        @endif
                    </span>

                    <span class="profile-text">
                        <span class="profile-name">
                            {{ $supplierUser->name }}
                        </span>

                        <span class="profile-role">Supplier</span>
                    </span>

                    <span class="profile-arrow">⌄</span>
                </button>

                <div class="profile-menu" id="profileMenu">
                    <div class="profile-summary">
                        <span class="profile-summary-avatar">
                            @if ($supplierPhoto)
                                <img
                                    src="{{ $supplierPhoto }}"
                                    alt="Foto profil {{ $supplierUser->name }}"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                >

                                <span class="avatar-fallback" style="display: none">
                                    {{ $supplierInitial }}
                                </span>
                            @else
                                <span class="avatar-fallback">
                                    {{ $supplierInitial }}
                                </span>
                            @endif
                        </span>

                        <div class="profile-summary-text">
                            <strong>{{ $supplierUser->name }}</strong>
                            <small>{{ $supplierUser->email }}</small>
                            <small>{{ $supplierUser->roleLabel() }}</small>
                        </div>
                    </div>

                    <a class="profile-item" href="{{ route('supplier.profil') }}">
                        ♙
                        <span>Profil Supplier</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="profile-item" type="submit">
                            ↪
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <section class="content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrap = document.getElementById('profileWrap');
            const button = document.getElementById('profileButton');
            const menu = document.getElementById('profileMenu');

            if (wrap && button && menu) {
                button.addEventListener('click', function () {
                    const isOpen = menu.classList.toggle('open');

                    button.setAttribute(
                        'aria-expanded',
                        isOpen ? 'true' : 'false'
                    );
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
            }

            const toggle = document.querySelector('.mobile-menu-toggle');
            const overlay = document.querySelector('[data-sidebar-close]');
            const sidebar = document.querySelector('.sidebar');

            function closeMenu() {
                document.body.classList.remove('sidebar-open');

                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.textContent = '☰';
                }
            }

            if (toggle) {
                toggle.addEventListener('click', function () {
                    const isOpen = document.body.classList.toggle('sidebar-open');

                    toggle.setAttribute('aria-expanded', String(isOpen));
                    toggle.textContent = isOpen ? '×' : '☰';
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeMenu);
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });

            if (sidebar) {
                sidebar.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 700) {
                            closeMenu();
                        }
                    });
                });
            }

            window.addEventListener('resize', function () {
                if (window.innerWidth > 700) {
                    closeMenu();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>