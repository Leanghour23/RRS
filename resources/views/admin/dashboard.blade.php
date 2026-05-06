@extends('layouts.master')

@section('title', 'Stay Safe Here | Dashboard')
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
        .admin-brand, .admin-topbar, .admin-profile, .admin-panel-head, .admin-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,255,255,0.98); color: var(--secondary); }
        .admin-link.active .admin-icon { background: rgba(37,99,235,0.12); color: var(--secondary); }
        .admin-main { padding: 26px; }
        .admin-topbar { position: sticky; top: 0; z-index: 30; margin: 0 -26px 22px; padding: 18px 26px 22px; background: linear-gradient(180deg, rgba(250,250,250,0.96) 0%, rgba(243,244,246,0.92) 100%); backdrop-filter: blur(12px); }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-profile-copy strong { color: var(--surface-dark); }
        .admin-profile-copy p, .admin-subtle { margin: 0; color: var(--muted); }
        .admin-avatar { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-stats, .admin-grid { display: grid; gap: 22px; }
        .admin-stats { position: sticky; top: 112px; z-index: 20; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 22px; padding-bottom: 6px; }
        .admin-card, .admin-panel { border-radius: 24px; background: rgba(255,255,255,0.95); box-shadow: 0 22px 46px rgba(15,23,42,0.07); border: 1px solid var(--line); }
        .admin-card { padding: 24px; }
        .admin-card strong { display: block; color: var(--surface-dark); font-size: 2rem; margin-bottom: 8px; }
        .admin-card.strong { background: linear-gradient(135deg, var(--primary), var(--surface-dark)); }
        .admin-card.strong strong, .admin-card.strong span { color: #fff; }
        .admin-grid { grid-template-columns: minmax(0, 1.5fr) minmax(320px, 0.9fr); }
        .admin-panel { overflow: hidden; }
        .admin-panel-head { padding: 20px 24px; border-bottom: 1px solid var(--line); }
        .admin-panel-body { padding: 12px 24px 24px; }
        .admin-row { padding: 16px 0; border-top: 1px solid var(--line); align-items: flex-start; }
        .admin-row:first-child { border-top: none; }
        .admin-row-main { display: grid; gap: 6px; }
        .admin-row-side { display: grid; gap: 10px; justify-items: end; }
        .admin-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
        .admin-row-main strong { color: var(--surface-dark); }
        .admin-badge { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--surface-dark); }
        .admin-action-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 10px 16px; border: none; border-radius: 999px; background: linear-gradient(135deg, var(--primary), var(--primary-deep)); color: #fff; font-weight: 700; cursor: pointer; box-shadow: 0 12px 24px rgba(17, 24, 39, 0.18); transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease; }
        .admin-action-btn:hover { transform: translateY(-1px); box-shadow: 0 16px 28px rgba(17, 24, 39, 0.22); }
        .admin-action-btn.reject { background: linear-gradient(135deg, var(--danger), var(--danger-deep)); box-shadow: 0 12px 24px rgba(239, 68, 68, 0.18); }
        .admin-action-btn.reject:hover { box-shadow: 0 16px 28px rgba(239, 68, 68, 0.22); }
        .admin-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .admin-dot.pending { background: var(--muted-soft); }
        .admin-dot.confirmed { background: var(--surface-dark); }
        .admin-dot.rejected { background: var(--danger); }
        .admin-dot.review { background: var(--muted); }
        @media (max-width: 1200px) { .admin-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 1024px) { .admin-shell { grid-template-columns: 1fr; } .admin-sidebar { position: static; min-height: auto; padding: 22px 18px; } .admin-menu { grid-template-columns: repeat(2, minmax(0, 1fr)); } .admin-grid { grid-template-columns: 1fr; } .admin-main { padding: 22px; } }
        @media (max-width: 768px) { .admin-menu, .admin-stats { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-panel-head, .admin-row { flex-direction: column; align-items: flex-start; } .admin-topbar, .admin-stats { position: static; margin: 0 0 22px; padding: 0; backdrop-filter: none; } .admin-panel-head { gap: 12px; } .admin-panel-head .button-secondary { width: 100%; } .admin-row-side, .admin-actions { justify-items: start; justify-content: flex-start; } .admin-main { padding: 18px; } .admin-card, .admin-panel-head, .admin-panel-body { padding-left: 18px; padding-right: 18px; } .admin-card strong { font-size: 1.75rem; } }
        @media (max-width: 480px) { .admin-brand { font-size: 1.15rem; } .admin-title { font-size: 1.65rem; } .admin-link { padding: 12px 14px; } .admin-row { gap: 10px; } }
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
                    <h1 class="admin-title">Dashboard</h1>
                    <p class="admin-subtle">Live operational summary for bookings, customers, and revenue.</p>
                </div>

                <div class="admin-profile">
                    <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="admin-profile-copy">
                        <strong>{{ auth()->user()->name }}</strong>
                        <p>{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-stats">
                @foreach ($metrics as $metric)
                    <article class="admin-card {{ $metric['accent'] === 'strong' ? 'strong' : '' }}">
                        <strong>{{ $metric['value'] }}</strong>
                        <span>{{ $metric['label'] }}</span>
                    </article>
                @endforeach
            </div>

            <div class="admin-grid">
                <article class="admin-panel">
                    <div class="admin-panel-head">
                        <div>
                            <strong>Recent Booking Requests</strong>
                            <p class="admin-subtle">Newest activity across the booking pipeline.</p>
                        </div>
                        <a href="{{ route('admin.booking') }}" class="button-secondary">View all</a>
                    </div>

                    <div class="admin-panel-body">
                        @forelse ($bookings as $booking)
                            <div class="admin-row">
                                <div class="admin-row-main">
                                    <strong>{{ $booking->code }} · {{ $booking->guest_name }}</strong>
                                    <p class="admin-subtle">{{ $booking->room->name ?? 'Unassigned room' }}</p>
                                    <p class="admin-subtle">
                                        {{ optional($booking->move_in_date)->format('d M Y') ?: 'No move-in date' }}
                                        · {{ $booking->duration_display }}
                                    </p>
                                </div>

                                <div class="admin-row-side">
                                    <span class="admin-badge">
                                        <span class="admin-dot {{ in_array($booking->status, ['pending', 'confirmed', 'rejected']) ? $booking->status : 'review' }}"></span>
                                        {{ ucfirst($booking->status) }}
                                    </span>

                                    @if ($booking->status === 'pending')
                                        <div class="admin-actions">
                                            <form method="POST" action="{{ route('admin.booking.accept', $booking) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="admin-action-btn">Accept</button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.booking.reject', $booking) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="admin-action-btn reject">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="admin-subtle">No booking requests yet.</p>
                        @endforelse
                    </div>
                </article>

                <article class="admin-panel">
                    <div class="admin-panel-head">
                        <div>
                            <strong>Latest Customers</strong>
                            <p class="admin-subtle">Recently created customer profiles.</p>
                        </div>
                        <a href="{{ route('admin.customers') }}" class="button-secondary">View all</a>
                    </div>

                    <div class="admin-panel-body">
                        @forelse ($customers as $customer)
                            <div class="admin-row">
                                <div class="admin-row-main">
                                    <strong>{{ $customer->user->name ?? 'Unknown user' }}</strong>
                                    <p class="admin-subtle">{{ $customer->role_title ?: 'Customer' }}</p>
                                    <p class="admin-subtle">{{ $customer->user->email ?? 'No email' }}</p>
                                </div>

                                <span class="soft-chip">{{ ucfirst($customer->status) }}</span>
                            </div>
                        @empty
                            <p class="admin-subtle">No customer profiles yet.</p>
                        @endforelse
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
