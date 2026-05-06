@extends('layouts.master')

@section('title', 'Stay Safe Here | Inventory')
@section('page_class', 'page-dashboard')
@section('hide_shell', '1')

@php
    $menuItems = [
        ['label' => 'Home', 'icon' => 'home', 'route' => 'home'],
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'dashboard'],
        ['label' => 'Bookings', 'icon' => 'bookings', 'route' => 'admin.booking'],
        ['label' => 'Customers', 'icon' => 'customers', 'route' => 'admin.customers'],
        ['label' => 'Inventory', 'icon' => 'inventory', 'route' => 'admin.inventory'],
    ];
@endphp

@push('head')
    <style>
        .page-dashboard .page-content { padding: 0; }
        .page-dashboard .page-frame { width: 100%; max-width: none; }
        .admin-shell { min-height: 100vh; display: grid; grid-template-columns: 260px minmax(0, 1fr); background: linear-gradient(180deg, var(--bg) 0%, var(--bg-accent) 100%); }
        .admin-sidebar { position: sticky; top: 0; align-self: start; min-height: 100vh; background: linear-gradient(180deg, var(--surface-dark) 0%, var(--primary) 100%); color: #fff; padding: 28px 22px; }
        .admin-brand, .admin-topbar, .admin-profile, .admin-panel-head, .inventory-row, .alert-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon, .alert-icon { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .admin-avatar, .alert-icon { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,255,255,0.98); color: var(--secondary); }
        .admin-link.active .admin-icon { background: rgba(37,99,235,0.12); color: var(--secondary); }
        .admin-main { padding: 26px; }
        .admin-topbar { position: sticky; top: 0; z-index: 30; margin: 0 -26px 22px; padding: 18px 26px 22px; background: linear-gradient(180deg, rgba(250,250,250,0.96) 0%, rgba(243,244,246,0.92) 100%); backdrop-filter: blur(12px); }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-subtle { margin: 0; color: var(--muted); }
        .admin-stats, .admin-grid { display: grid; gap: 22px; }
        .admin-stats { position: sticky; top: 112px; z-index: 20; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 22px; padding-bottom: 6px; }
        .admin-card, .admin-panel { border-radius: 24px; background: rgba(255,255,255,0.95); box-shadow: 0 22px 46px rgba(15,23,42,0.07); border: 1px solid var(--line); }
        .admin-card { padding: 24px; }
        .admin-card strong { display: block; color: var(--surface-dark); font-size: 2rem; margin-bottom: 8px; }
        .admin-grid { grid-template-columns: minmax(0, 1fr); }
        .admin-panel { overflow: hidden; }
        .admin-panel-head { padding: 20px 24px; border-bottom: 1px solid var(--line); }
        .admin-panel-body { padding: 12px 24px 24px; }
        .inventory-row, .alert-row { padding: 16px 0; border-top: 1px solid var(--line); align-items: flex-start; }
        .inventory-row:first-child, .alert-row:first-child { border-top: none; }
        .inventory-visual { width: 96px; min-width: 96px; height: 78px; border-radius: 18px; background-position: center; background-size: cover; background-repeat: no-repeat; box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18); }
        .inventory-content, .inventory-main, .alert-copy { display: grid; gap: 6px; }
        .inventory-content { grid-template-columns: 96px minmax(0, 1fr); align-items: start; gap: 16px; }
        .inventory-main strong, .alert-copy strong { color: var(--surface-dark); }
        .inventory-side { display: grid; gap: 10px; justify-items: end; }
        .inventory-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
        .admin-mini-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 10px 18px; border-radius: 999px; font-size: 0.88rem; font-weight: 700; border: 1px solid var(--line); background: rgba(255,255,255,0.9); color: var(--surface-dark); box-shadow: 0 10px 20px rgba(15,23,42,0.06); cursor: pointer; transition: background-color 160ms ease, color 160ms ease, box-shadow 160ms ease, transform 160ms ease, border-color 160ms ease; }
        .admin-mini-btn:hover,
        .admin-mini-btn:focus-visible,
        .admin-mini-btn:active { background: rgba(255,255,255,0.98); color: var(--surface-dark); border-color: rgba(37,99,235,0.16); box-shadow: 0 14px 26px rgba(15,23,42,0.1); transform: translateY(-1px); }
        .admin-mini-btn.delete { border-color: rgba(239,68,68,0.18); background: rgba(239,68,68,0.08); color: var(--danger-deep); }
        .admin-mini-btn.delete:hover,
        .admin-mini-btn.delete:focus-visible,
        .admin-mini-btn.delete:active { background: rgba(254,242,242,0.98); border-color: rgba(239,68,68,0.14); color: var(--danger-deep); box-shadow: 0 14px 26px rgba(239,68,68,0.12); }
        @media (max-width: 1100px) { .admin-shell { grid-template-columns: 1fr; } .admin-sidebar { position: static; min-height: auto; } .admin-stats, .admin-grid, .admin-menu { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 780px) { .admin-stats, .admin-grid, .admin-menu, .inventory-content { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-panel-head, .inventory-row, .alert-row { flex-direction: column; align-items: flex-start; } .admin-topbar, .admin-stats { position: static; margin: 0 0 22px; padding: 0; backdrop-filter: none; } .inventory-side, .inventory-actions { justify-items: start; justify-content: flex-start; } .inventory-visual { width: 100%; height: 180px; } .admin-main { padding: 18px; } }
    </style>
@endpush

@section('content')
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <x-site-logo mark-class="admin-brand-mark" variant="light" />
            </div>

            <nav class="admin-menu">
                @foreach ($menuItems as $item)
                    <a href="{{ route($item['route']) }}" class="admin-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <span class="admin-icon"><x-admin-menu-icon :name="$item['icon']" /></span>
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
                        <a href="{{ route('admin.rooms.create') }}" class="button-secondary">Add Room</a>
                    </div>

                    <div class="admin-panel-body">
                        @forelse ($rooms as $room)
                            <div class="inventory-row">
                                <div class="inventory-content">
                                    <div
                                        class="inventory-visual room-image--{{ $room->theme }}"
                                        @if ($room->image_url)
                                            style="background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.14), rgba(15, 23, 42, 0.46)), url('{{ $room->image_url }}');"
                                        @endif
                                    ></div>

                                    <div class="inventory-main">
                                        <strong>{{ $room->name }}</strong>
                                        <p class="admin-subtle">{{ $room->room_type ?: 'Room listing' }}</p>
                                        <p class="admin-subtle">
                                            {{ $room->location }} · {{ $room->price_display }}{{ $room->period_display }} · {{ $room->booking_requests_count }} requests
                                        </p>
                                    </div>
                                </div>

                                <div class="inventory-side">
                                    <span class="soft-chip">{{ ucfirst($room->status) }}</span>
                                    <div class="inventory-actions">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="admin-mini-btn">Update</a>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Delete this room?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-mini-btn delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="admin-subtle">No rooms found in inventory.</p>
                        @endforelse
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
