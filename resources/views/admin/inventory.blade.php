@extends('layouts.master')

@section('title', 'StaySphere | Inventory')
@section('page_class', 'page-dashboard')
@section('hide_shell', '1')

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'DB', 'route' => 'dashboard'],
        ['label' => 'Bookings', 'icon' => 'BK', 'route' => 'admin.booking'],
        ['label' => 'Customers', 'icon' => 'CU', 'route' => 'admin.customers'],
        ['label' => 'Inventory', 'icon' => 'IN', 'route' => 'admin.inventory'],
    ];
@endphp

@push('head')
    <style>
        .page-dashboard .page-content { padding: 0; }
        .page-dashboard .page-frame { width: 100%; max-width: none; }
        .admin-shell { min-height: 100vh; display: grid; grid-template-columns: 260px minmax(0, 1fr); background: linear-gradient(180deg, #f8f2ea 0%, #efe3d5 100%); }
        .admin-sidebar { background: linear-gradient(180deg, var(--surface-dark) 0%, var(--primary) 100%); color: #fff; padding: 28px 22px; }
        .admin-brand, .admin-topbar, .admin-profile, .admin-panel-head, .inventory-row, .alert-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon, .alert-icon { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .admin-avatar, .alert-icon { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,250,244,0.98); color: var(--surface-dark); }
        .admin-link.active .admin-icon { background: rgba(35,83,71,0.12); color: var(--surface-dark); }
        .admin-main { padding: 26px; }
        .admin-topbar { padding-bottom: 22px; }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-subtle { margin: 0; color: var(--muted); }
        .admin-stats, .admin-grid { display: grid; gap: 22px; }
        .admin-stats { grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 22px; }
        .admin-card, .admin-panel { border-radius: 24px; background: rgba(255,250,244,0.95); box-shadow: 0 22px 46px rgba(27,29,37,0.07); }
        .admin-card { padding: 24px; }
        .admin-card strong { display: block; color: var(--surface-dark); font-size: 2rem; margin-bottom: 8px; }
        .admin-grid { grid-template-columns: minmax(0, 1.5fr) minmax(300px, 0.9fr); }
        .admin-panel { overflow: hidden; }
        .admin-panel-head { padding: 20px 24px; border-bottom: 1px solid rgba(35,83,71,0.08); }
        .admin-panel-body { padding: 12px 24px 24px; }
        .inventory-row, .alert-row { padding: 16px 0; border-top: 1px solid rgba(35,83,71,0.08); align-items: flex-start; }
        .inventory-row:first-child, .alert-row:first-child { border-top: none; }
        .inventory-main, .alert-copy { display: grid; gap: 6px; }
        .inventory-main strong, .alert-copy strong { color: var(--surface-dark); }
        @media (max-width: 1100px) { .admin-shell { grid-template-columns: 1fr; } .admin-stats, .admin-grid, .admin-menu { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 780px) { .admin-stats, .admin-grid, .admin-menu { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-panel-head, .inventory-row, .alert-row { flex-direction: column; align-items: flex-start; } .admin-main { padding: 18px; } }
    </style>
@endpush

@section('content')
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <span class="admin-brand-mark">SS</span>
                <span>StaySafeHere</span>
            </div>

            <nav class="admin-menu">
                @foreach ($menuItems as $item)
                    <a href="{{ route($item['route']) }}" class="admin-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <span class="admin-icon">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <section class="admin-main">
            <div class="admin-topbar">
                <div>
                    <h1 class="admin-title">Inventory Control</h1>
                    <p class="admin-subtle">Room catalog, current status, and watch items.</p>
                </div>

                <div class="admin-profile">
                    <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <p class="admin-subtle">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-stats">
                @foreach ($inventoryStats as $stat)
                    <article class="admin-card">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </article>
                @endforeach
            </div>

            <div class="admin-grid">
                <article class="admin-panel">
                    <div class="admin-panel-head">
                        <div>
                            <strong>Room Inventory</strong>
                            <p class="admin-subtle">Catalog records now backed by the database.</p>
                        </div>
                    </div>

                    <div class="admin-panel-body">
                        @forelse ($rooms as $room)
                            <div class="inventory-row">
                                <div class="inventory-main">
                                    <strong>{{ $room->name }}</strong>
                                    <p class="admin-subtle">{{ $room->room_type ?: 'Room listing' }}</p>
                                    <p class="admin-subtle">
                                        {{ $room->location }} · {{ $room->price_display }}{{ $room->period_display }} · {{ $room->booking_requests_count }} requests
                                    </p>
                                </div>

                                <span class="soft-chip">{{ ucfirst($room->status) }}</span>
                            </div>
                        @empty
                            <p class="admin-subtle">No rooms found in inventory.</p>
                        @endforelse
                    </div>
                </article>

                <article class="admin-panel">
                    <div class="admin-panel-head">
                        <div>
                            <strong>Inventory Alerts</strong>
                            <p class="admin-subtle">Rooms that need attention or are underutilized.</p>
                        </div>
                    </div>

                    <div class="admin-panel-body">
                        @forelse ($alerts as $index => $room)
                            <div class="alert-row">
                                <div class="alert-icon">{{ $index + 1 }}</div>
                                <div class="alert-copy">
                                    <strong>{{ $room->name }}</strong>
                                    <p class="admin-subtle">
                                        Status: {{ ucfirst($room->status) }}. Requests: {{ $room->booking_requests_count }}.
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="admin-subtle">No alerts right now.</p>
                        @endforelse
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
