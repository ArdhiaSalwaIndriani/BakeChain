 @extends('supplier.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard Supplier')

@section('content')
<style>
    .supplier-dashboard {
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: #172033;
    }

    .supplier-dashboard * {
        box-sizing: border-box;
    }

    .supplier-dashboard .welcome-banner {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 190px;
        padding: 32px 36px;
        border-radius: 22px;
        color: #fff;
        background: linear-gradient(120deg, #a90f25 0%, #d51f36 58%, #ed4755 100%);
        box-shadow: 0 12px 28px rgba(190, 24, 48, 0.16);
    }

    .supplier-dashboard .welcome-banner::before,
    .supplier-dashboard .welcome-banner::after {
        position: absolute;
        content: "";
        border: 1px solid rgba(255, 255, 255, 0.13);
        border-radius: 50%;
        pointer-events: none;
    }

    .supplier-dashboard .welcome-banner::before {
        width: 300px;
        height: 300px;
        right: -45px;
        top: -155px;
    }

    .supplier-dashboard .welcome-banner::after {
        width: 230px;
        height: 230px;
        right: 70px;
        bottom: -175px;
    }

    .supplier-dashboard .welcome-copy {
        position: relative;
        z-index: 1;
    }

    .supplier-dashboard .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.8px;
        color: rgba(255, 255, 255, 0.85);
    }

    .supplier-dashboard .eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #fff;
    }

    .supplier-dashboard .welcome-banner h2 {
        margin: 0;
        color: #fff;
        font-size: clamp(23px, 3vw, 31px);
        line-height: 1.3;
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .supplier-dashboard .welcome-banner p {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
    }

    .supplier-dashboard .welcome-icon {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 76px;
        width: 76px;
        height: 76px;
        margin-left: 24px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.13);
        font-size: 34px;
    }

    .supplier-dashboard .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .supplier-dashboard .stat-card {
        position: relative;
        overflow: hidden;
        min-width: 0;
        padding: 23px;
        border: 1px solid #e9edf3;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(21, 35, 58, 0.035);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .supplier-dashboard .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(21, 35, 58, 0.08);
    }

    .supplier-dashboard .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 21px;
    }

    .supplier-dashboard .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        border-radius: 13px;
        font-size: 20px;
    }

    .supplier-dashboard .icon-red {
        color: #c21e35;
        background: #fff0f2;
    }

    .supplier-dashboard .icon-blue {
        color: #2563eb;
        background: #eff6ff;
    }

    .supplier-dashboard .icon-orange {
        color: #c76b0a;
        background: #fff7ed;
    }

    .supplier-dashboard .icon-purple {
        color: #7c3aed;
        background: #f5f0ff;
    }

    .supplier-dashboard .stat-label {
        margin: 0;
        color: #68758a;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.5;
    }

    .supplier-dashboard .stat-value {
        margin: 7px 0 0;
        color: #182235;
        font-size: 32px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .supplier-dashboard .stat-caption {
        margin: 9px 0 0;
        color: #8993a4;
        font-size: 11px;
    }

    .supplier-dashboard .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
        gap: 20px;
        align-items: stretch;
    }

    .supplier-dashboard .dashboard-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e8edf3;
        border-radius: 19px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(21, 35, 58, 0.035);
    }

    .supplier-dashboard .panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 24px 25px 18px;
    }

    .supplier-dashboard .panel-title {
        margin: 0;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
    }

    .supplier-dashboard .panel-description {
        margin: 7px 0 0;
        color: #8490a2;
        font-size: 12px;
        line-height: 1.5;
    }

    .supplier-dashboard .panel-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
        padding: 8px 11px;
        border-radius: 9px;
        color: #bd1930;
        background: #fff1f2;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .supplier-dashboard .panel-link:hover {
        background: #ffe1e5;
    }

    .supplier-dashboard .chart-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 25px 12px;
    }

    .supplier-dashboard .chart-total {
        color: #172033;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.8px;
    }

    .supplier-dashboard .chart-total-label {
        color: #8490a2;
        font-size: 12px;
    }

    .supplier-dashboard .chart-wrap {
        position: relative;
        width: 100%;
        height: 240px;
        padding: 8px 18px 20px;
    }

    .supplier-dashboard .chart-wrap svg {
        display: block;
        width: 100%;
        height: 100%;
        overflow: visible;
    }

    .supplier-dashboard .chart-grid-line {
        stroke: #edf0f5;
        stroke-width: 1;
    }

    .supplier-dashboard .chart-bar {
        transition: opacity 0.2s ease;
    }

    .supplier-dashboard .chart-bar:hover {
        opacity: 0.76;
    }

    .supplier-dashboard .chart-label {
        fill: #7c8798;
        font-size: 10px;
        font-family: inherit;
    }

    .supplier-dashboard .chart-number {
        fill: #253148;
        font-size: 11px;
        font-weight: 700;
        font-family: inherit;
    }

    .supplier-dashboard .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 16px;
        padding: 0 25px 24px;
    }

    .supplier-dashboard .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #657186;
        font-size: 11px;
    }

    .supplier-dashboard .legend-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 3px;
    }

    .supplier-dashboard .status-table,
    .supplier-dashboard .request-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .supplier-dashboard .status-table th,
    .supplier-dashboard .request-table th {
        padding: 12px 24px;
        color: #8993a4;
        background: #fafbfd;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .supplier-dashboard .status-table td,
    .supplier-dashboard .request-table td {
        padding: 15px 24px;
        border-top: 1px solid #f0f2f6;
        color: #465267;
        font-size: 12px;
        vertical-align: middle;
    }

    .supplier-dashboard .status-table th:first-child,
    .supplier-dashboard .status-table td:first-child,
    .supplier-dashboard .request-table th:first-child,
    .supplier-dashboard .request-table td:first-child {
        padding-left: 32px;
    }

    .supplier-dashboard .status-table th:last-child,
    .supplier-dashboard .status-table td:last-child,
    .supplier-dashboard .request-table th:last-child,
    .supplier-dashboard .request-table td:last-child {
        padding-right: 38px;
    }

    .supplier-dashboard .status-table tbody tr,
    .supplier-dashboard .request-table tbody tr {
        transition: background 0.15s ease;
    }

    .supplier-dashboard .status-table tbody tr:hover,
    .supplier-dashboard .request-table tbody tr:hover {
        background: #fafbfe;
    }

    .supplier-dashboard .status-name {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #344054;
        font-weight: 600;
        white-space: nowrap;
    }

    .supplier-dashboard .status-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .supplier-dashboard .status-count {
        color: #172033;
        font-size: 13px;
        font-weight: 800;
        text-align: center;
    }

    .supplier-dashboard .status-action {
        color: #bd1930;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .supplier-dashboard .status-action:hover {
        text-decoration: underline;
    }

    .supplier-dashboard .status-direncanakan {
        background: #94a3b8;
    }

    .supplier-dashboard .status-diproses {
        background: #8b5cf6;
    }

    .supplier-dashboard .status-dikirim {
        background: #3b82f6;
    }

    .supplier-dashboard .status-diterima {
        background: #16a34a;
    }

    .supplier-dashboard .status-dibatalkan {
        background: #ef4444;
    }

    .supplier-dashboard .status-default {
        background: #c21e35;
    }

    .supplier-dashboard .request-code {
        color: #bd1930;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .supplier-dashboard .request-code:hover {
        text-decoration: underline;
    }

    .supplier-dashboard .request-material {
        min-width: 110px;
        color: #344054;
        font-weight: 600;
    }

    .supplier-dashboard .request-quantity {
        color: #566276;
        white-space: nowrap;
    }

    .supplier-dashboard .request-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .supplier-dashboard .request-status.st-direncanakan {
        color: #64748b;
        background: #f1f5f9;
    }

    .supplier-dashboard .request-status.st-diproses {
        color: #7c3aed;
        background: #f5f0ff;
    }

    .supplier-dashboard .request-status.st-dikirim {
        color: #1d4ed8;
        background: #eff6ff;
    }

    .supplier-dashboard .request-status.st-diterima {
        color: #15803d;
        background: #f0fdf4;
    }

    .supplier-dashboard .request-status.st-dibatalkan {
        color: #b91c1c;
        background: #fef2f2;
    }

    .supplier-dashboard .empty-state {
        padding: 42px 24px !important;
        color: #8993a4 !important;
        text-align: center;
    }

    .supplier-dashboard .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        margin: 0 auto 12px;
        border-radius: 14px;
        color: #bd1930;
        background: #fff1f2;
        font-size: 21px;
    }

    .supplier-dashboard .empty-state p {
        margin: 0;
        font-size: 12px;
    }

    .supplier-dashboard .unlinked-panel {
        padding: 26px;
        border: 1px solid #fecdd3;
        border-radius: 17px;
        background: #fff7f8;
        color: #881337;
        font-size: 13px;
        line-height: 1.8;
    }

    .supplier-dashboard .unlinked-title {
        margin: 0 0 7px;
        font-size: 16px;
        font-weight: 800;
    }

    @media (max-width: 1150px) {
        .supplier-dashboard .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .supplier-dashboard .dashboard-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 640px) {
        .supplier-dashboard {
            gap: 16px;
        }

        .supplier-dashboard .welcome-banner {
            min-height: 155px;
            padding: 25px 22px;
            border-radius: 17px;
        }

        .supplier-dashboard .welcome-banner h2 {
            font-size: 23px;
        }

        .supplier-dashboard .welcome-banner p {
            font-size: 12px;
        }

        .supplier-dashboard .welcome-icon {
            width: 48px;
            height: 48px;
            flex-basis: 48px;
            margin-left: 10px;
            border-radius: 14px;
            font-size: 23px;
        }

        .supplier-dashboard .eyebrow {
            font-size: 9px;
            letter-spacing: 1px;
        }

        .supplier-dashboard .stats-grid {
            gap: 11px;
        }

        .supplier-dashboard .stat-card {
            padding: 16px;
            border-radius: 15px;
        }

        .supplier-dashboard .stat-top {
            margin-bottom: 15px;
        }

        .supplier-dashboard .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 17px;
        }

        .supplier-dashboard .stat-label {
            font-size: 11px;
        }

        .supplier-dashboard .stat-value {
            font-size: 27px;
        }

        .supplier-dashboard .stat-caption {
            font-size: 10px;
            line-height: 1.5;
        }

        .supplier-dashboard .panel-header {
            padding: 20px 17px 16px;
        }

        .supplier-dashboard .panel-title {
            font-size: 15px;
        }

        .supplier-dashboard .panel-description {
            font-size: 11px;
        }

        .supplier-dashboard .status-table th,
        .supplier-dashboard .status-table td {
            padding: 13px 15px;
        }

        .supplier-dashboard .request-table th,
        .supplier-dashboard .request-table td {
            padding: 13px 15px;
        }

        .supplier-dashboard .status-table th:first-child,
        .supplier-dashboard .status-table td:first-child,
        .supplier-dashboard .request-table th:first-child,
        .supplier-dashboard .request-table td:first-child {
            padding-left: 18px;
        }

        .supplier-dashboard .status-table th:last-child,
        .supplier-dashboard .status-table td:last-child,
        .supplier-dashboard .request-table th:last-child,
        .supplier-dashboard .request-table td:last-child {
            padding-right: 18px;
        }

        .supplier-dashboard .chart-wrap {
            height: 205px;
            padding: 8px 10px 15px;
        }

        .supplier-dashboard .chart-summary,
        .supplier-dashboard .chart-legend {
            padding-left: 18px;
            padding-right: 18px;
        }

        .supplier-dashboard .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .supplier-dashboard .request-table {
            min-width: 510px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .supplier-dashboard *,
        .supplier-dashboard *::before,
        .supplier-dashboard *::after {
            transition: none !important;
        }
    }
    .supplier-dashboard .status-table th:first-child,
    .supplier-dashboard .status-table td:first-child,
    .supplier-dashboard .request-table th:first-child,
    .supplier-dashboard .request-table td:first-child {
        padding-left: 46px !important;
    }

    .supplier-dashboard .status-table th:last-child,
    .supplier-dashboard .status-table td:last-child,
    .supplier-dashboard .request-table th:last-child,
    .supplier-dashboard .request-table td:last-child {
        padding-right: 52px !important;
    }

    @media (max-width: 640px) {
        .supplier-dashboard .status-table th:first-child,
        .supplier-dashboard .status-table td:first-child,
        .supplier-dashboard .request-table th:first-child,
        .supplier-dashboard .request-table td:first-child {
            padding-left: 24px !important;
        }

        .supplier-dashboard .status-table th:last-child,
        .supplier-dashboard .status-table td:last-child,
        .supplier-dashboard .request-table th:last-child,
        .supplier-dashboard .request-table td:last-child {
            padding-right: 24px !important;
        }
    }
</style>

<div class="supplier-dashboard">
    <section class="welcome-banner">
        <div class="welcome-copy">
            <div class="eyebrow">
                <span class="eyebrow-dot"></span>
                BAKECHAIN · SUPPLIER
            </div>
            <h2>Selamat datang, {{ auth()->user()->name }}</h2>
            <p>{{ $supplier ? $supplier->nama_supplier : 'Akun belum ditautkan ke data supplier.' }}</p>
        </div>
    </section>

    @if (! $supplier)
        <section class="unlinked-panel">
            <h3 class="unlinked-title">Akun supplier belum terhubung</h3>
            Akun kamu belum ditautkan ke data supplier, sehingga permintaan bahan belum dapat ditampilkan. Hubungi Admin atau Pemilik UMKM untuk menautkan akun ini.
        </section>
    @else
        @php
            $statusLabels = [
                'direncanakan' => 'Direncanakan',
                'diproses' => 'Diproses',
                'dikirim' => 'Dikirim',
                'diterima' => 'Diterima',
                'dibatalkan' => 'Dibatalkan',
            ];

            $statusColors = [
                'direncanakan' => '#94a3b8',
                'diproses' => '#8b5cf6',
                'dikirim' => '#3b82f6',
                'diterima' => '#16a34a',
                'dibatalkan' => '#ef4444',
            ];

            $statusIcons = [
                'direncanakan' => '◷',
                'diproses' => '⚙',
                'dikirim' => '↗',
                'diterima' => '✓',
                'dibatalkan' => '×',
            ];

            $totalStatus = collect($counts)->sum();
            $chartMaximum = max(1, (int) collect($counts)->max());
            $statusCount = count($counts);
        @endphp

        <section class="stats-grid">
            <article class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon icon-red">▤</div>
                    <span class="eyebrow" style="margin:0;color:#bd1930;letter-spacing:0">TOTAL</span>
                </div>
                <p class="stat-label">Total Permintaan</p>
                <h3 class="stat-value">{{ $totalPermintaan }}</h3>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon icon-orange">◷</div>
                    <span class="eyebrow" style="margin:0;color:#c76b0a;letter-spacing:0">TINDAKAN</span>
                </div>
                <p class="stat-label">Perlu Ditindaklanjuti</p>
                <h3 class="stat-value">{{ $perluDitindaklanjuti }}</h3>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon icon-blue">↗</div>
                    <span class="eyebrow" style="margin:0;color:#2563eb;letter-spacing:0">PENGIRIMAN</span>
                </div>
                <p class="stat-label">Sedang Dikirim</p>
                <h3 class="stat-value">{{ $counts['dikirim'] ?? 0 }}</h3>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon icon-purple">◷</div>
                    <span class="eyebrow" style="margin:0;color:#7c3aed;letter-spacing:0">BATCH</span>
                </div>
                <p class="stat-label">Batch Hampir Kedaluwarsa</p>
                <h3 class="stat-value">{{ $batchHampirKadaluarsa }}</h3>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-panel">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Grafik Status Pesanan</h3>
                    </div>
                </div>

                <div class="chart-wrap">
                    <svg viewBox="0 0 340 205" role="img" aria-label="Grafik batang jumlah permintaan untuk setiap status pesanan">
                        @php
                            $chartLeft = 35;
                            $chartRight = 328;
                            $chartTop = 20;
                            $chartBottom = 158;
                            $chartHeight = $chartBottom - $chartTop;
                            $chartWidth = $chartRight - $chartLeft;
                            $slotWidth = $statusCount > 0 ? $chartWidth / $statusCount : $chartWidth;
                            $barWidth = min(30, $slotWidth * 0.53);
                        @endphp

                        @for ($tick = 0; $tick <= 3; $tick++)
                            @php
                                $gridY = $chartBottom - ($chartHeight * $tick / 3);
                                $gridValue = (int) ceil($chartMaximum * $tick / 3);
                            @endphp
                            <line x1="{{ $chartLeft }}" y1="{{ $gridY }}" x2="{{ $chartRight }}" y2="{{ $gridY }}" class="chart-grid-line" />
                            <text x="{{ $chartLeft - 8 }}" y="{{ $gridY + 4 }}" class="chart-label" text-anchor="end">{{ $gridValue }}</text>
                        @endfor

                        @foreach ($counts as $status => $total)
                            @php
                                $index = $loop->index;
                                $barX = $chartLeft + ($slotWidth * $index) + (($slotWidth - $barWidth) / 2);
                                $barHeight = $chartHeight * ((int) $total / $chartMaximum);
                                $barY = $chartBottom - $barHeight;
                                $color = $statusColors[$status] ?? '#c21e35';
                                $label = $statusLabels[$status] ?? ucfirst($status);
                            @endphp

                            <rect
                                class="chart-bar"
                                x="{{ $barX }}"
                                y="{{ $barY }}"
                                width="{{ $barWidth }}"
                                height="{{ max(0, $barHeight) }}"
                                rx="5"
                                fill="{{ $color }}"
                            />
                            <text x="{{ $barX + ($barWidth / 2) }}" y="{{ max(12, $barY - 8) }}" class="chart-number" text-anchor="middle">{{ $total }}</text>
                            <text x="{{ $barX + ($barWidth / 2) }}" y="178" class="chart-label" text-anchor="middle">{{ mb_strimwidth($label, 0, 11, '…') }}</text>
                        @endforeach
                    </svg>
                </div>

                <div class="chart-legend">
                    @foreach ($counts as $status => $total)
                        <span class="legend-item">
                            <span class="legend-dot" style="background:{{ $statusColors[$status] ?? '#c21e35' }}"></span>
                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                        </span>
                    @endforeach
                </div>
            </article>

            <article class="dashboard-panel">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Status Pesanan</h3>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="status-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th style="text-align:center">Jumlah</th>
                                <th style="text-align:right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($counts as $status => $total)
                                <tr>
                                    <td>
                                        <span class="status-name">
                                            <span class="status-dot status-{{ \Illuminate\Support\Str::slug($status) }}"></span>
                                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="status-count">{{ $total }}</td>
                                    <td style="text-align:right">
                                        <a class="status-action" href="{{ route('supplier.permintaan', ['status' => $status]) }}">Lihat →</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">
                                        <p>Belum ada data status pesanan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="panel-title">Permintaan Terbaru</h3>
                </div>
                <a class="panel-link" href="{{ route('supplier.permintaan') }}">Lihat semua <span aria-hidden="true">→</span></a>
            </div>

            <div class="table-wrap">
                <table class="request-table">
                    <thead>
                        <tr>
                            <th>Kode Pembelian</th>
                            <th>Bahan Baku</th>
                            <th>Jumlah</th>
                            <th>Status Pesanan</th>
                            <th style="text-align:right">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($terbaru as $item)
                            @php
                                $itemStatus = \Illuminate\Support\Str::slug($item->status);
                            @endphp
                            <tr>
                                <td>
                                    <a class="request-code" href="{{ route('supplier.permintaan.show', $item->id) }}">
                                        {{ $item->kode_pembelian }}
                                    </a>
                                </td>
                                <td class="request-material">{{ $item->nama_bahan }}</td>
                                <td class="request-quantity">{{ (float) $item->jumlah }} {{ $item->satuan }}</td>
                                <td>
                                    <span class="request-status st-{{ $itemStatus }}">
                                        {{ $statusLabels[$item->status] ?? ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td style="text-align:right">
                                    <a class="status-action" href="{{ route('supplier.permintaan.show', $item->id) }}">Buka →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <div class="empty-icon">▤</div>
                                    <p>Belum ada permintaan bahan baku.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif
</div>
@endsection