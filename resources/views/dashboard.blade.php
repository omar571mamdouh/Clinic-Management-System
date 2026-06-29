@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

    .dash-root {
        font-family: 'DM Sans', sans-serif;
        background: #070d1a;
        min-height: 100vh;
        padding: 2rem 2.5rem;
        background-image:
            linear-gradient(rgba(6,182,212,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(6,182,212,0.02) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* ── Header ── */
    .dash-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        animation: fadeDown 0.4s ease both;
    }
    .dash-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #f0f6ff;
        letter-spacing: -0.03em;
        line-height: 1;
    }
    .dash-subtitle {
        color: #3a5070;
        font-size: 0.8rem;
        margin-top: 0.35rem;
        font-family: 'DM Mono', monospace;
    }
    .dash-date {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        color: #3a5070;
        background: #0d1829;
        border: 1px solid #172438;
        padding: 0.35rem 0.8rem;
        border-radius: 8px;
    }

    /* ── Stat Cards ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #0d1829;
        border: 1px solid #172438;
        border-radius: 14px;
        padding: 1.1rem 1.2rem;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s, transform 0.2s;
        animation: fadeUp 0.4s ease both;
    }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.08s; }
    .stat-card:nth-child(3) { animation-delay: 0.11s; }
    .stat-card:nth-child(4) { animation-delay: 0.14s; }
    .stat-card:nth-child(5) { animation-delay: 0.17s; }
    .stat-card:nth-child(6) { animation-delay: 0.20s; }
    .stat-card:nth-child(7) { animation-delay: 0.23s; }
    .stat-card:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: var(--accent);
        opacity: 0.5;
    }
    .stat-card[data-accent="cyan"]   { --accent: #06b6d4; }
    .stat-card[data-accent="blue"]   { --accent: #3b82f6; }
    .stat-card[data-accent="amber"]  { --accent: #f59e0b; }
    .stat-card[data-accent="rose"]   { --accent: #f43f5e; }
    .stat-card[data-accent="violet"] { --accent: #8b5cf6; }
    .stat-card[data-accent="green"]  { --accent: #22c55e; }
    .stat-card[data-accent="orange"] { --accent: #fb923c; }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.7rem;
    }
    .stat-label {
        font-size: 0.7rem;
        color: #3a5070;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        font-family: 'DM Mono', monospace;
    }
    .stat-icon-wrap {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        background: color-mix(in srgb, var(--accent) 10%, transparent);
    }
    .stat-icon-wrap svg { width: 14px; height: 14px; color: var(--accent); }
    .stat-value {
        font-size: 2rem;
        font-weight: 600;
        color: #f0f6ff;
        letter-spacing: -0.04em;
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    .stat-mini {
        font-size: 0.7rem;
        color: #3a5070;
        font-family: 'DM Mono', monospace;
        margin-top: 0.3rem;
    }
    .stat-mini span { color: var(--accent); }

    /* ── Section label ── */
    .section-label {
        font-size: 0.7rem;
        font-family: 'DM Mono', monospace;
        color: #2d4060;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.85rem;
        margin-top: 0.2rem;
    }

    /* ── Charts Row 1: 3 columns ── */
    .charts-row1 {
        display: grid;
        grid-template-columns: 1fr 1.4fr 1fr;
        gap: 0.85rem;
        margin-bottom: 0.85rem;
        animation: fadeUp 0.4s 0.2s ease both;
    }

    /* ── Charts Row 2: 2 columns ── */
    .charts-row2 {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.4s 0.25s ease both;
    }

    .chart-card {
        background: #0d1829;
        border: 1px solid #172438;
        border-radius: 14px;
        padding: 1.2rem 1.3rem;
    }
    .chart-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .chart-title {
        font-size: 0.72rem;
        font-family: 'DM Mono', monospace;
        color: #3a5070;
        text-transform: uppercase;
        letter-spacing: 0.09em;
    }
    .chart-badge {
        font-family: 'DM Mono', monospace;
        font-size: 0.68rem;
        padding: 0.15rem 0.5rem;
        border-radius: 5px;
        background: rgba(6,182,212,0.08);
        color: #06b6d4;
    }
    .chart-wrap {
        position: relative;
    }
    .chart-wrap-sm { height: 160px; }
    .chart-wrap-md { height: 180px; }
    .chart-wrap-lg { height: 200px; }

    /* Donut center text */
    .donut-center {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }
    .donut-center-val {
        font-size: 1.5rem;
        font-weight: 600;
        color: #f0f6ff;
        letter-spacing: -0.04em;
        line-height: 1;
    }
    .donut-center-lbl {
        font-size: 0.62rem;
        font-family: 'DM Mono', monospace;
        color: #3a5070;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-top: 2px;
    }

    /* Mini legend */
    .mini-legend {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        margin-top: 0.9rem;
    }
    .mini-legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #5a7090;
    }
    .mini-dot {
        width: 6px; height: 6px;
        border-radius: 2px;
        flex-shrink: 0;
    }
    .mini-val {
        margin-left: auto;
        font-family: 'DM Mono', monospace;
        color: #a0b8d0;
        font-size: 0.72rem;
    }

    /* Inline legend (horizontal) */
    .inline-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-bottom: 0.7rem;
    }
    .inline-legend-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.7rem;
        color: #5a7090;
        font-family: 'DM Mono', monospace;
    }
    .inline-sq {
        width: 8px; height: 8px;
        border-radius: 2px;
    }

    /* Activity log list */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid #0f1c2e;
        font-size: 0.78rem;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        margin-top: 4px;
        flex-shrink: 0;
    }
    .activity-msg { color: #7090b0; flex: 1; line-height: 1.4; }
    .activity-msg strong { color: #a0c0e0; font-weight: 500; }
    .activity-time {
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        color: #2d4060;
        white-space: nowrap;
    }

    /* ── Table ── */
    .table-card {
        background: #0d1829;
        border: 1px solid #172438;
        border-radius: 14px;
        overflow: hidden;
        animation: fadeUp 0.4s 0.3s ease both;
    }
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.3rem;
        border-bottom: 1px solid #172438;
    }
    .table-title {
        font-size: 0.72rem;
        font-family: 'DM Mono', monospace;
        color: #3a5070;
        text-transform: uppercase;
        letter-spacing: 0.09em;
    }
    .table-count {
        font-family: 'DM Mono', monospace;
        font-size: 0.7rem;
        color: #06b6d4;
        background: rgba(6,182,212,0.07);
        padding: 0.15rem 0.5rem;
        border-radius: 5px;
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 0.65rem 1.3rem;
        font-size: 0.68rem;
        font-family: 'DM Mono', monospace;
        color: #243650;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        text-align: left;
        background: #080f1c;
        border-bottom: 1px solid #172438;
    }
    tbody tr {
        border-bottom: 1px solid #0f1c2e;
        transition: background 0.12s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(6,182,212,0.025); }
    tbody td {
        padding: 0.8rem 1.3rem;
        font-size: 0.83rem;
        color: #6080a0;
    }
    .td-name { color: #c0d8f0; font-weight: 500; }
    .td-time {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        color: #3a5070;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.55rem;
        border-radius: 20px;
        font-size: 0.68rem;
        font-family: 'DM Mono', monospace;
        font-weight: 500;
        text-transform: capitalize;
    }
    .badge::before {
        content: '';
        width: 4px; height: 4px;
        border-radius: 50%;
        background: currentColor;
    }
    .badge-pending   { background: rgba(245,158,11,0.1);  color: #f59e0b; }
    .badge-done      { background: rgba(34,197,94,0.1);   color: #22c55e; }
    .badge-cancelled { background: rgba(244,63,94,0.1);   color: #f43f5e; }

    .empty-state {
        text-align: center;
        padding: 2.5rem;
        color: #243650;
        font-family: 'DM Mono', monospace;
        font-size: 0.78rem;
    }

    /* ── Animations ── */
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(4, 1fr); }
        .charts-row1 { grid-template-columns: 1fr 1fr; }
        .charts-row2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-row1 { grid-template-columns: 1fr; }
        .dash-root { padding: 1rem; }
    }
</style>

<div class="dash-root">

    {{-- Header --}}
    <div class="dash-header">
        <div>
            <div class="dash-title">Dashboard</div>
            <div class="dash-subtitle">clinic_overview.sys</div>
        </div>
        <div class="dash-date">{{ now()->format('D, d M Y') }}</div>
    </div>

    {{-- Stats Row --}}
    <div class="section-label">system overview</div>
    <div class="stats-grid">

        <div class="stat-card" data-accent="cyan">
            <div class="stat-top">
                <div class="stat-label">Patients</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $patientsCount }}">0</div>
            <div class="stat-mini">total registered</div>
        </div>

        <div class="stat-card" data-accent="blue">
            <div class="stat-top">
                <div class="stat-label">Doctors</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $doctorsCount }}">0</div>
            <div class="stat-mini">active staff</div>
        </div>

        <div class="stat-card" data-accent="amber">
            <div class="stat-top">
                <div class="stat-label">Today</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $todayAppointments }}">0</div>
            <div class="stat-mini">appointments</div>
        </div>

        <div class="stat-card" data-accent="rose">
            <div class="stat-top">
                <div class="stat-label">Pending</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $pendingAppointments }}">0</div>
            <div class="stat-mini">needs action</div>
        </div>

        <div class="stat-card" data-accent="violet">
            <div class="stat-top">
                <div class="stat-label">Med Records</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414A1 1 0 0 1 19 9.414V19a2 2 0 0 1-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $medicalRecordsCount ?? 0 }}">0</div>
            <div class="stat-mini">total records</div>
        </div>

        <div class="stat-card" data-accent="green">
            <div class="stat-top">
                <div class="stat-label">Users</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $usersCount ?? 0 }}">0</div>
            <div class="stat-mini">system users</div>
        </div>

        <div class="stat-card" data-accent="orange">
            <div class="stat-top">
                <div class="stat-label">Notifications</div>
                <div class="stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value" data-count="{{ $unreadNotifications ?? 0 }}">0</div>
            <div class="stat-mini"><span>unread</span> alerts</div>
        </div>


        <div class="stat-card" data-accent="green">
    <div class="stat-top">
        <div class="stat-label">Revenue</div>
        <div class="stat-icon-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
            </svg>
        </div>
    </div>
    <div class="stat-value" data-count="{{ (int)($totalRevenue ?? 0) }}">0</div>
    <div class="stat-mini"><span>{{ $paidPayments ?? 0 }} paid</span> · {{ $pendingPayments ?? 0 }} pending</div>
</div>
    </div>

    {{-- Charts Row 1: Donut | Line | Horizontal Bar --}}
    <div class="section-label" style="margin-top:1.2rem">analytics</div>
    <div class="charts-row1">

        {{-- Donut: Appointment Status --}}
        <div class="chart-card">
            <div class="chart-head">
                <span class="chart-title">Appointment Status</span>
            </div>
            <div class="chart-wrap chart-wrap-sm" style="position:relative;">
                <canvas id="statusDonut" role="img" aria-label="Donut chart showing appointment status breakdown">
                    Pending: {{ $pendingAppointments }}, Done: {{ $completedAppointments }}, Cancelled: {{ $cancelledAppointments ?? 0 }}
                </canvas>
                <div class="donut-center">
                    <div class="donut-center-val">{{ ($pendingAppointments + $completedAppointments + ($cancelledAppointments ?? 0)) }}</div>
                    <div class="donut-center-lbl">total</div>
                </div>
            </div>
            <div class="mini-legend">
                <div class="mini-legend-item">
                    <span class="mini-dot" style="background:#f59e0b"></span>
                    Pending
                    <span class="mini-val">{{ $pendingAppointments }}</span>
                </div>
                <div class="mini-legend-item">
                    <span class="mini-dot" style="background:#22c55e"></span>
                    Done
                    <span class="mini-val">{{ $completedAppointments }}</span>
                </div>
                <div class="mini-legend-item">
                    <span class="mini-dot" style="background:#f43f5e"></span>
                    Cancelled
                    <span class="mini-val">{{ $cancelledAppointments ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Line: Weekly Appointments --}}
        <div class="chart-card">
            <div class="chart-head">
                <span class="chart-title">Weekly Appointments</span>
                <span class="chart-badge">last 7 days</span>
            </div>
            <div class="inline-legend">
                <div class="inline-legend-item">
                    <span class="inline-sq" style="background:#06b6d4"></span>total
                </div>
                <div class="inline-legend-item">
                    <span class="inline-sq" style="background:#22c55e"></span>done
                </div>
                <div class="inline-legend-item">
                    <span class="inline-sq" style="background:#f59e0b; opacity:.7"></span>pending
                </div>
            </div>
            <div class="chart-wrap chart-wrap-md">
                <canvas id="weeklyLine" role="img" aria-label="Line chart showing weekly appointment trends">Weekly appointments over the last 7 days.</canvas>
            </div>
        </div>

        {{-- Horizontal Bar: Doctors Workload --}}
        <div class="chart-card">
            <div class="chart-head">
                <span class="chart-title">Doctor Workload</span>
                <span class="chart-badge">appointments</span>
            </div>
            <div class="chart-wrap" style="height:{{ max(160, ($doctorsCount ?? 5) * 38) }}px">
                <canvas id="doctorBar" role="img" aria-label="Horizontal bar chart showing appointments per doctor">Appointments per doctor.</canvas>
            </div>
        </div>

    </div>

    {{-- Charts Row 2: Area (Records over months) | Stacked bar (Roles) --}}
    <div class="charts-row2">

        {{-- Area: Medical Records Over Months --}}
        <div class="chart-card">
            <div class="chart-head">
                <span class="chart-title">Medical Records — Monthly</span>
                <span class="chart-badge">this year</span>
            </div>
            <div class="inline-legend">
                <div class="inline-legend-item">
                    <span class="inline-sq" style="background:#8b5cf6"></span>records added
                </div>
                <div class="inline-legend-item">
                    <span class="inline-sq" style="background:#06b6d4"></span>new patients
                </div>
            </div>
            <div class="chart-wrap chart-wrap-lg">
                <canvas id="recordsArea" role="img" aria-label="Area chart showing medical records and new patients per month">Monthly medical records and new patients.</canvas>
            </div>
        </div>

        {{-- Doughnut: Users by Role --}}
        <div class="chart-card">
            <div class="chart-head">
                <span class="chart-title">Users by Role</span>
            </div>
            <div class="chart-wrap chart-wrap-sm" style="position:relative;">
                <canvas id="rolesDonut" role="img" aria-label="Donut chart showing user distribution by role">User roles distribution.</canvas>
                <div class="donut-center">
                    <div class="donut-center-val">{{ $usersCount ?? 0 }}</div>
                    <div class="donut-center-lbl">users</div>
                </div>
            </div>
            <div class="mini-legend">
                @if(isset($roleStats) && count($roleStats))
                    @php $roleColors = ['#06b6d4','#8b5cf6','#22c55e','#f59e0b','#f43f5e','#fb923c']; @endphp
                    @foreach($roleStats as $i => $role)
                        <div class="mini-legend-item">
                            <span class="mini-dot" style="background:{{ $roleColors[$i % count($roleColors)] }}"></span>
                            {{ $role->name }}
                            <span class="mini-val">{{ $role->users_count }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="mini-legend-item" style="color:#2d4060">no role data</div>
                @endif
            </div>
        </div>

    </div>

    {{-- Charts Row 3: Payments --}}
<div class="charts-row2" style="margin-top: 0;">

    {{-- Line: Monthly Revenue --}}
    <div class="chart-card">
        <div class="chart-head">
            <span class="chart-title">Revenue — Monthly</span>
            <span class="chart-badge">this year</span>
        </div>
        <div class="inline-legend">
            <div class="inline-legend-item">
                <span class="inline-sq" style="background:#22c55e"></span>paid
            </div>
            <div class="inline-legend-item">
                <span class="inline-sq" style="background:#f59e0b"></span>pending
            </div>
            <div class="inline-legend-item">
                <span class="inline-sq" style="background:#f43f5e"></span>failed
            </div>
        </div>
        <div class="chart-wrap chart-wrap-lg">
            <canvas id="revenueArea" role="img" aria-label="Line chart showing monthly revenue"></canvas>
        </div>
    </div>

    {{-- Donut: Payment Status --}}
    <div class="chart-card">
        <div class="chart-head">
            <span class="chart-title">Payment Status</span>
        </div>
        <div class="chart-wrap chart-wrap-sm" style="position:relative;">
            <canvas id="paymentDonut" role="img" aria-label="Donut chart showing payment status breakdown"></canvas>
            <div class="donut-center">
                <div class="donut-center-val">${{ number_format($totalRevenue ?? 0, 0) }}</div>
                <div class="donut-center-lbl">revenue</div>
            </div>
        </div>
        <div class="mini-legend">
            <div class="mini-legend-item">
                <span class="mini-dot" style="background:#22c55e"></span>
                Paid
                <span class="mini-val">{{ $paidPayments ?? 0 }}</span>
            </div>
            <div class="mini-legend-item">
                <span class="mini-dot" style="background:#f59e0b"></span>
                Pending
                <span class="mini-val">{{ $pendingPayments ?? 0 }}</span>
            </div>
            <div class="mini-legend-item">
                <span class="mini-dot" style="background:#f43f5e"></span>
                Failed
                <span class="mini-val">{{ $failedPayments ?? 0 }}</span>
            </div>
        </div>
    </div>

</div>

    {{-- Activity Log --}}
    <div class="section-label">recent activity</div>
    <div class="chart-card" style="margin-bottom:1.5rem; animation: fadeUp 0.4s 0.3s ease both;">
        <div class="activity-list">
            @forelse($recentActivities ?? [] as $log)
                <div class="activity-item">
                    <span class="activity-dot" style="background:#06b6d4"></span>
                    <span class="activity-msg">
                        <strong>{{ $log->causer->name ?? 'System' }}</strong>
                        {{ $log->description }}
                    </span>
                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="empty-state">— no recent activity —</div>
            @endforelse
        </div>
    </div>

    {{-- Today's Appointments Table --}}
    <div class="section-label">today's schedule</div>
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Today's Appointments</span>
            <span class="table-count">{{ $todayAppointments }} total</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayList as $item)
                    <tr>
                        <td class="td-name">{{ $item->patient->name }}</td>
                        <td>{{ $item->doctor->name }}</td>
                        <td class="td-time">{{ $item->appointment_time }}</td>
                        <td>
                            <span class="badge badge-{{ $item->status }}">{{ $item->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">— no appointments today —</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Count-up
    document.querySelectorAll('.stat-value[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count) || 0;
        if (!target) { el.textContent = '0'; return; }
        let v = 0;
        const step = Math.ceil(target / 25);
        const t = setInterval(() => {
            v = Math.min(v + step, target);
            el.textContent = v;
            if (v >= target) clearInterval(t);
        }, 28);
    });

    const gridColor = 'rgba(255,255,255,0.04)';
    const tickColor = '#2d4060';
    const tickFont  = { family: 'DM Mono', size: 10 };

    // ── 1. Status Donut ──
    new Chart(document.getElementById('statusDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Done', 'Cancelled'],
            datasets: [{
                data: [{{ $pendingAppointments }}, {{ $completedAppointments }}, {{ $cancelledAppointments ?? 0 }}],
                backgroundColor: ['#f59e0b', '#22c55e', '#f43f5e'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            cutout: '75%',
            plugins: { legend: { display: false }, tooltip: {
                callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed }
            }},
            animation: { animateRotate: true, duration: 700 }
        }
    });

    // ── 2. Weekly Line ──
    const weekLabels = {!! json_encode($weeklyLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!};
    const weekTotal  = {!! json_encode($weeklyTotal  ?? [0,0,0,0,0,0,0]) !!};
    const weekDone   = {!! json_encode($weeklyDone   ?? [0,0,0,0,0,0,0]) !!};
    const weekPend   = {!! json_encode($weeklyPending ?? [0,0,0,0,0,0,0]) !!};

    new Chart(document.getElementById('weeklyLine'), {
        type: 'line',
        data: {
            labels: weekLabels,
            datasets: [
                {
                    label: 'Total',
                    data: weekTotal,
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6,182,212,0.07)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 1.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#06b6d4',
                    borderDash: [],
                },
                {
                    label: 'Done',
                    data: weekDone,
                    borderColor: '#22c55e',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.4,
                    borderWidth: 1.5,
                    pointRadius: 2,
                    pointBackgroundColor: '#22c55e',
                    borderDash: [4,3],
                },
                {
                    label: 'Pending',
                    data: weekPend,
                    borderColor: '#f59e0b',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.4,
                    borderWidth: 1.5,
                    pointRadius: 2,
                    pointBackgroundColor: '#f59e0b',
                    borderDash: [2,3],
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: tickColor, font: tickFont }, grid: { color: gridColor } },
                y: { ticks: { color: tickColor, font: tickFont }, grid: { color: gridColor }, beginAtZero: true }
            },
            animation: { duration: 700 }
        }
    });

    // ── 3. Doctor Horizontal Bar ──
    const doctorNames  = {!! json_encode($doctorWorkload->pluck('name')->values()->toArray()) !!};
    const doctorCounts = {!! json_encode($doctorWorkload->pluck('appointments_count')->values()->toArray()) !!};

    new Chart(document.getElementById('doctorBar'), {
        type: 'bar',
        data: {
            labels: doctorNames,
            datasets: [{
                label: 'Appointments',
                data: doctorCounts,
                backgroundColor: 'rgba(59,130,246,0.5)',
                borderColor: '#3b82f6',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: tickColor, font: tickFont }, grid: { color: gridColor }, beginAtZero: true },
                y: { ticks: { color: '#5a7090', font: tickFont }, grid: { display: false } }
            },
            animation: { duration: 700 }
        }
    });

    // ── 4. Medical Records Area ──
    const monthLabels   = {!! json_encode($monthlyLabels  ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']) !!};
    const monthRecords  = {!! json_encode($monthlyRecords  ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
    const monthPatients = {!! json_encode($monthlyPatients ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};

    new Chart(document.getElementById('recordsArea'), {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Records',
                    data: monthRecords,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 1.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#8b5cf6',
                    borderDash: [],
                },
                {
                    label: 'New Patients',
                    data: monthPatients,
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6,182,212,0.06)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 1.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#06b6d4',
                    borderDash: [4,3],
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: tickColor, font: tickFont, autoSkip: false, maxRotation: 0 }, grid: { color: gridColor } },
                y: { ticks: { color: tickColor, font: tickFont }, grid: { color: gridColor }, beginAtZero: true }
            },
            animation: { duration: 700 }
        }
    });

    // ── 5. Roles Donut ──
    @if(isset($roleStats) && count($roleStats))
    const roleColors = ['#06b6d4','#8b5cf6','#22c55e','#f59e0b','#f43f5e','#fb923c'];
    new Chart(document.getElementById('rolesDonut'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(collect($roleStats)->pluck('name')->values()->toArray()) !!},
            datasets: [{
                data: {!! json_encode(collect($roleStats)->pluck('users_count')->values()->toArray()) !!},
                backgroundColor: roleColors.slice(0, {{ count($roleStats) }}),
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            cutout: '72%',
            plugins: { legend: { display: false } },
            animation: { animateRotate: true, duration: 700 }
        }
    });
    @else
    new Chart(document.getElementById('rolesDonut'), {
        type: 'doughnut',
        data: {
            labels: ['No Data'],
            datasets: [{ data: [1], backgroundColor: ['#172438'], borderWidth: 0 }]
        },
        options: { cutout: '72%', plugins: { legend: { display: false }, tooltip: { enabled: false } } }
    });
    @endif

    // ── 6. Revenue Area Chart ──
const revMonthLabels  = {!! json_encode($revenueMonthlyLabels  ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']) !!};
const revPaid         = {!! json_encode($revenueMonthlyPaid    ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
const revPending      = {!! json_encode($revenueMonthlyPending ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
const revFailed       = {!! json_encode($revenueMonthlyFailed  ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};

new Chart(document.getElementById('revenueArea'), {
    type: 'line',
    data: {
        labels: revMonthLabels,
        datasets: [
            {
                label: 'Paid',
                data: revPaid,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.08)',
                fill: true, tension: 0.4, borderWidth: 1.5,
                pointRadius: 3, pointBackgroundColor: '#22c55e',
            },
            {
                label: 'Pending',
                data: revPending,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245,158,11,0.05)',
                fill: true, tension: 0.4, borderWidth: 1.5,
                pointRadius: 2, pointBackgroundColor: '#f59e0b',
                borderDash: [4,3],
            },
            {
                label: 'Failed',
                data: revFailed,
                borderColor: '#f43f5e',
                backgroundColor: 'transparent',
                fill: false, tension: 0.4, borderWidth: 1.5,
                pointRadius: 2, pointBackgroundColor: '#f43f5e',
                borderDash: [2,3],
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: tickColor, font: tickFont, maxRotation: 0 }, grid: { color: gridColor } },
            y: {
                ticks: {
                    color: tickColor, font: tickFont,
                    callback: v => '$' + v.toLocaleString()
                },
                grid: { color: gridColor }, beginAtZero: true
            }
        },
        animation: { duration: 700 }
    }
});

// ── 7. Payment Status Donut ──
new Chart(document.getElementById('paymentDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Paid', 'Pending', 'Failed'],
        datasets: [{
            data: [{{ $paidPayments ?? 0 }}, {{ $pendingPayments ?? 0 }}, {{ $failedPayments ?? 0 }}],
            backgroundColor: ['#22c55e', '#f59e0b', '#f43f5e'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        cutout: '75%',
        plugins: { legend: { display: false } },
        animation: { animateRotate: true, duration: 700 }
    }
});
</script>

@endsection