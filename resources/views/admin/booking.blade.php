@extends('layouts.master')

@section('title', 'Stay Safe Here | Booking Management')
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
        .admin-shell { min-height: 100vh; display: grid; grid-template-columns: 260px minmax(0, 1fr); background: linear-gradient(180deg, #f8f2ea 0%, #efe3d5 100%); }
        .admin-sidebar { position: sticky; top: 0; align-self: start; min-height: 100vh; background: linear-gradient(180deg, var(--surface-dark) 0%, var(--primary) 100%); color: #fff; padding: 28px 22px; }
        .admin-brand, .admin-topbar, .admin-profile, .admin-panel-head, .booking-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,250,244,0.98); color: var(--surface-dark); }
        .admin-link.active .admin-icon { background: rgba(35,83,71,0.12); color: var(--surface-dark); }
        .admin-main { padding: 26px; }
        .admin-topbar { position: sticky; top: 0; z-index: 30; margin: 0 -26px 22px; padding: 18px 26px 22px; background: linear-gradient(180deg, rgba(248,242,234,0.96) 0%, rgba(239,227,213,0.92) 100%); backdrop-filter: blur(12px); }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-subtle { margin: 0; color: var(--muted); }
        .admin-avatar { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-stats { position: sticky; top: 112px; z-index: 20; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 22px; margin-bottom: 22px; padding-bottom: 6px; }
        .admin-card, .admin-panel { border-radius: 24px; background: rgba(255,250,244,0.95); box-shadow: 0 22px 46px rgba(27,29,37,0.07); }
        .admin-card { padding: 24px; }
        .admin-card strong { display: block; color: var(--surface-dark); font-size: 2rem; margin-bottom: 8px; }
        .admin-panel { overflow: hidden; }
        .admin-panel-head { padding: 20px 24px; border-bottom: 1px solid rgba(35,83,71,0.08); }
        .admin-panel-body { padding: 12px 24px 24px; }
        .booking-row { padding: 16px 0; border-top: 1px solid rgba(35,83,71,0.08); align-items: flex-start; }
        .booking-row:first-child { border-top: none; }
        .booking-main { display: grid; gap: 6px; }
        .booking-side { display: grid; gap: 10px; justify-items: end; }
        .booking-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
        .booking-main strong { color: var(--surface-dark); }
        .booking-meta { display: flex; flex-wrap: wrap; gap: 10px; color: var(--muted); font-size: 0.92rem; }
        .admin-badge { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--surface-dark); }
        .admin-action-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 10px 16px; border: none; border-radius: 999px; background: linear-gradient(135deg, var(--primary), #2a6a5a); color: #fff; font-weight: 700; cursor: pointer; box-shadow: 0 12px 24px rgba(35, 83, 71, 0.18); transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease; }
        .admin-action-btn:hover { transform: translateY(-1px); box-shadow: 0 16px 28px rgba(35, 83, 71, 0.22); }
        .admin-action-btn.reject { background: linear-gradient(135deg, #bf6d4d, #a34f2d); box-shadow: 0 12px 24px rgba(163, 79, 45, 0.18); }
        .admin-action-btn.reject:hover { box-shadow: 0 16px 28px rgba(163, 79, 45, 0.22); }
        .admin-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .admin-dot.pending { background: #d49b2d; }
        .admin-dot.confirmed { background: var(--primary); }
        .admin-dot.rejected { background: #bf6d4d; }
        .admin-dot.review { background: var(--secondary); }
        @media (max-width: 1100px) { .admin-shell { grid-template-columns: 1fr; } .admin-sidebar { position: static; min-height: auto; } .admin-stats, .admin-menu { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 780px) { .admin-stats, .admin-menu { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-panel-head, .booking-row { flex-direction: column; align-items: flex-start; } .admin-topbar, .admin-stats { position: static; margin: 0 0 22px; padding: 0; backdrop-filter: none; } .booking-side, .booking-actions { justify-items: start; justify-content: flex-start; } .admin-main { padding: 18px; } }
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
                    <h1 class="admin-title">Booking Management</h1>
                    <p class="admin-subtle">Review incoming requests and track expected revenue.</p>
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
                @foreach ($bookingStats as $stat)
                    <article class="admin-card">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </article>
                @endforeach
            </div>

            <article class="admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <strong>Booking Requests</strong>
                        <p class="admin-subtle">All booking submissions stored from the website.</p>
                    </div>
                </div>

                <div class="admin-panel-body">
                    @forelse ($bookings as $booking)
                        <div class="booking-row">
                            <div class="booking-main">
                                <strong>{{ $booking->code }} · {{ $booking->guest_name }}</strong>
                                <p class="admin-subtle">{{ $booking->room->name ?? 'Unassigned room' }}</p>
                                <div class="booking-meta">
                                    <span>{{ $booking->guest_email }}</span>
                                    <span>{{ optional($booking->move_in_date)->format('d M Y') ?: 'No move-in date' }}</span>
                                    <span>{{ $booking->duration_display }}</span>
                                    @if ($booking->total_amount)
                                        <span>${{ number_format((float) $booking->total_amount, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="booking-side">
                                <span class="admin-badge">
                                    <span class="admin-dot {{ in_array($booking->status, ['pending', 'confirmed', 'rejected']) ? $booking->status : 'review' }}"></span>
                                    {{ ucfirst($booking->status) }}
                                </span>

                                @if ($booking->status === 'pending')
                                    <div class="booking-actions">
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
                        <p class="admin-subtle">No bookings have been submitted yet.</p>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection
