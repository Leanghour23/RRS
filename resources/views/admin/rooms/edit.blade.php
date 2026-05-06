@extends('layouts.master')

@section('title', 'Stay Safe Here | Update Room')
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
        .admin-sidebar { background: linear-gradient(180deg, var(--surface-dark) 0%, var(--primary) 100%); color: #fff; padding: 28px 22px; }
        .admin-brand, .admin-topbar, .admin-profile { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-brand { justify-content: flex-start; margin-bottom: 28px; font-size: 1.4rem; font-weight: 800; }
        .admin-brand-mark, .admin-avatar, .admin-icon { width: 36px; height: 36px; border-radius: 12px; display: grid; place-items: center; background: rgba(255,255,255,0.14); color: #fff; font-size: 0.78rem; font-weight: 800; }
        .admin-avatar { border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--primary)); }
        .admin-menu { display: grid; gap: 10px; }
        .admin-link { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 18px; color: rgba(255,255,255,0.92); }
        .admin-link.active { background: rgba(255,255,255,0.98); color: var(--secondary); }
        .admin-link.active .admin-icon { background: rgba(37,99,235,0.12); color: var(--secondary); }
        .admin-main { padding: 26px; }
        .admin-topbar { padding-bottom: 22px; }
        .admin-title { margin: 0; color: var(--surface-dark); font-size: 2rem; }
        .admin-subtle { margin: 0; color: var(--muted); }
        .admin-profile-copy strong { color: var(--surface-dark); }
        .admin-form-card { max-width: 920px; border-radius: 24px; background: rgba(255,255,255,0.95); box-shadow: 0 22px 46px rgba(15,23,42,0.07); padding: 24px; border: 1px solid var(--line); }
        .admin-form-grid { display: grid; gap: 18px; }
        .admin-form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .admin-field { display: grid; gap: 8px; }
        .admin-field label { font-weight: 700; color: var(--surface-dark); }
        .admin-field input, .admin-field select, .admin-field textarea { width: 100%; padding: 14px 16px; border-radius: 16px; border: 1px solid var(--line); background: rgba(255,255,255,0.9); color: var(--text); outline: none; }
        .admin-field input:focus, .admin-field select:focus, .admin-field textarea:focus { border-color: rgba(37,99,235,0.4); box-shadow: 0 0 0 4px rgba(37,99,235,0.12); }
        .admin-input-group { display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: center; border: 1px solid var(--line); border-radius: 16px; background: rgba(255,255,255,0.9); overflow: hidden; }
        .admin-input-group input { border: none; border-radius: 0; background: transparent; box-shadow: none; }
        .admin-input-group input:focus { box-shadow: none; }
        .admin-input-suffix { padding: 14px 16px; color: var(--muted); background: rgba(240,253,250,0.9); border-left: 1px solid var(--line); font-weight: 700; }
        .admin-checkbox { display: flex; align-items: center; gap: 10px; color: var(--surface-dark); font-weight: 700; }
        .admin-checkbox input { width: 18px; height: 18px; }
        .admin-actions { display: flex; align-items: center; gap: 12px; }
        .admin-error { margin-bottom: 18px; padding: 14px 16px; border-radius: 16px; background: var(--danger-soft); color: var(--danger-deep); border: 1px solid rgba(239, 68, 68, 0.18); }
        .admin-preview { max-width: 220px; border-radius: 18px; overflow: hidden; border: 1px solid var(--line); }
        .admin-preview img { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; }
        @media (max-width: 1100px) { .admin-shell { grid-template-columns: 1fr; } .admin-menu { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 780px) { .admin-menu, .admin-form-row { grid-template-columns: 1fr; } .admin-topbar, .admin-profile, .admin-actions { flex-direction: column; align-items: flex-start; } .admin-main { padding: 18px; } }
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
                    <a href="{{ route($item['route']) }}" class="admin-link {{ ($item['route'] === 'admin.inventory' && request()->routeIs('admin.rooms.create', 'admin.rooms.edit')) || request()->routeIs($item['route']) ? 'active' : '' }}">
                        <span class="admin-icon"><x-admin-menu-icon :name="$item['icon']" /></span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <section class="admin-main">
            <div class="admin-topbar">
                <div>
                    <h1 class="admin-title">Update Room</h1>
                    <p class="admin-subtle">Edit this room listing and save the latest details.</p>
                </div>

                <div class="admin-profile">
                    <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="admin-profile-copy">
                        <strong>{{ auth()->user()->name }}</strong>
                        <p class="admin-subtle">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <article class="admin-form-card">
                @if ($errors->any())
                    <div class="admin-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data" class="admin-form-grid">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="name">Room Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $room->name) }}" required>
                        </div>
                        <div class="admin-field">
                            <label for="location">Location</label>
                            <input id="location" name="location" type="text" value="{{ old('location', $room->location) }}" required>
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="room_type">Room Type</label>
                            <input id="room_type" name="room_type" type="text" value="{{ old('room_type', $room->room_type) }}" placeholder="Private room, studio, shared room">
                        </div>
                        <div class="admin-field">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="available" @selected(old('status', $room->status) === 'available')>Available</option>
                                <option value="occupied" @selected(old('status', $room->status) === 'occupied')>Occupied</option>
                                <option value="maintenance" @selected(old('status', $room->status) === 'maintenance')>Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="price">Price</label>
                            <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $room->price) }}" required>
                        </div>
                        <div class="admin-field">
                            <label for="deposit">Deposit</label>
                            <input id="deposit" name="deposit" type="number" step="0.01" min="0" value="{{ old('deposit', $room->deposit) }}">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="price_period">Price Period</label>
                            <div class="admin-input-group">
                                <input id="price_period" name="price_period" type="number" min="1" value="{{ old('price_period', $room->price_period_value ?? 1) }}" required>
                                <span class="admin-input-suffix">month</span>
                            </div>
                        </div>
                        <div class="admin-field">
                            <label for="available_from_label">Available From</label>
                            <input id="available_from_label" name="available_from_label" type="text" value="{{ old('available_from_label', $room->available_from_label) }}" placeholder="Available now">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="capacity_label">Capacity</label>
                            <input id="capacity_label" name="capacity_label" type="text" value="{{ old('capacity_label', $room->capacity_label) }}" placeholder="2 guests">
                        </div>
                        <div class="admin-field">
                            <label for="size_label">Size</label>
                            <input id="size_label" name="size_label" type="text" value="{{ old('size_label', $room->size_label) }}" placeholder="28 sqm">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="bathroom">Bathroom</label>
                            <input id="bathroom" name="bathroom" type="text" value="{{ old('bathroom', $room->bathroom) }}" placeholder="Private bathroom">
                        </div>
                        <div class="admin-field">
                            <label for="furnishing">Furnishing</label>
                            <input id="furnishing" name="furnishing" type="text" value="{{ old('furnishing', $room->furnishing) }}" placeholder="Fully furnished">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="theme">Theme</label>
                            <input id="theme" name="theme" type="text" value="{{ old('theme', $room->theme) }}" placeholder="minimal, oakwood, skyline">
                        </div>
                        <div class="admin-field">
                            <label for="availability_label">Availability Label</label>
                            <input id="availability_label" name="availability_label" type="text" value="{{ old('availability_label', $room->availability_label) }}" placeholder="1 room left">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="image">Replace Room Photo</label>
                            <input id="image" name="image" type="file" accept="image/*">
                        </div>
                        <div class="admin-field">
                            <label for="utilities_label">Utilities</label>
                            <input id="utilities_label" name="utilities_label" type="text" value="{{ old('utilities_label', $room->utilities_label) }}" placeholder="Wi-Fi, water, electricity">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="visit_label">Visit</label>
                            <input id="visit_label" name="visit_label" type="text" value="{{ old('visit_label', $room->visit_label) }}" placeholder="Schedule a visit anytime">
                        </div>
                        <div class="admin-field">
                            <label for="contract_label">Contract</label>
                            <input id="contract_label" name="contract_label" type="text" value="{{ old('contract_label', $room->contract_label) }}" placeholder="6-month minimum stay">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-field">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" placeholder="Short room summary">{{ old('description', $room->description) }}</textarea>
                        </div>
                        <div class="admin-field">
                            <label>Current Photo</label>
                            @if ($room->image_url)
                                <div class="admin-preview">
                                    <img src="{{ $room->image_url }}" alt="{{ $room->name }}">
                                </div>
                            @else
                                <p class="admin-subtle">No uploaded photo yet. Theme background is being used.</p>
                            @endif
                        </div>
                    </div>

                    <label class="admin-checkbox" for="is_featured">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $room->is_featured))>
                        <span>Feature this room on the website</span>
                    </label>

                    <div class="admin-actions">
                        <button type="submit" class="button-link">Save Changes</button>
                        <a href="{{ route('admin.inventory') }}" class="button-secondary">Cancel</a>
                    </div>
                </form>
            </article>
        </section>
    </div>
@endsection
