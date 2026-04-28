@extends('layouts.master')

@section('title', 'StaySphere | Customers')
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
        .admin-brand, .admin-topbar, .admin-profile, .admin-panel-head, .customer-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon, .customer-avatar { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .customer-avatar, .admin-avatar { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,250,244,0.98); color: var(--surface-dark); }
        .admin-link.active .admin-icon { background: rgba(35,83,71,0.12); color: var(--surface-dark); }
        .admin-main { padding: 26px; }
        .admin-topbar { padding-bottom: 22px; }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-subtle { margin: 0; color: var(--muted); }
        .admin-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 22px; margin-bottom: 22px; }
        .admin-card, .admin-panel { border-radius: 24px; background: rgba(255,250,244,0.95); box-shadow: 0 22px 46px rgba(27,29,37,0.07); }
        .admin-card { padding: 24px; }
        .admin-card strong { display: block; color: var(--surface-dark); font-size: 2rem; margin-bottom: 8px; }
        .admin-panel { overflow: hidden; }
        .admin-panel-head { padding: 20px 24px; border-bottom: 1px solid rgba(35,83,71,0.08); }
        .admin-panel-body { padding: 12px 24px 24px; }
        .customer-row { padding: 16px 0; border-top: 1px solid rgba(35,83,71,0.08); }
        .customer-row:first-child { border-top: none; }
        .customer-main { display: flex; align-items: center; gap: 14px; }
        .customer-copy { display: grid; gap: 4px; }
        .customer-copy strong { color: var(--surface-dark); }
        @media (max-width: 1100px) { .admin-shell { grid-template-columns: 1fr; } .admin-stats, .admin-menu { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 780px) { .admin-stats, .admin-menu { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-panel-head, .customer-row { flex-direction: column; align-items: flex-start; } .admin-main { padding: 18px; } }
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
                    <h1 class="admin-title">Customer Directory</h1>
                    <p class="admin-subtle">Profiles linked to registered users.</p>
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
                @foreach ($customerStats as $stat)
                    <article class="admin-card">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </article>
                @endforeach
            </div>

            <article class="admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <strong>Customer Profiles</strong>
                        <p class="admin-subtle">Registered renters and their attached profile metadata.</p>
                    </div>
                </div>

                <div class="admin-panel-body">
                    @forelse ($customers as $customer)
                        <div class="customer-row">
                            <div class="customer-main">
                                <div class="customer-avatar">{{ strtoupper(substr($customer->user->name ?? 'U', 0, 1)) }}</div>
                                <div class="customer-copy">
                                    <strong>{{ $customer->user->name ?? 'Unknown user' }}</strong>
                                    <p class="admin-subtle">{{ $customer->user->email ?? 'No email' }}</p>
                                    <p class="admin-subtle">
                                        {{ $customer->role_title ?: 'Customer' }}
                                        @if ($customer->city)
                                            · {{ $customer->city }}
                                        @endif
                                        @if ($customer->phone)
                                            · {{ $customer->phone }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <span class="soft-chip">{{ ucfirst($customer->status) }}</span>
                        </div>
                    @empty
                        <p class="admin-subtle">No customer profiles yet.</p>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection
