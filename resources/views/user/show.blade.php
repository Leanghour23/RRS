@extends('layouts.master')

@section('title', $room->name . ' | Room Information')
@section('page_class', 'page-room-detail')

@push('head')
    <style>
        .room-detail-layout {
            display: grid;
            gap: 24px;
        }

        .room-detail-hero {
            overflow: hidden;
        }

        .room-detail-cover {
            min-height: 360px;
            padding: 28px;
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            color: #fff;
        }

        .room-detail-cover h1 {
            margin: 0 0 10px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.2rem, 5vw, 4rem);
            line-height: 1.05;
        }

        .room-detail-cover p {
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
        }

        .room-detail-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .room-detail-header-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .room-detail-pill {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            font-weight: 700;
        }

        .room-detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.8fr);
            gap: 24px;
        }

        .room-detail-card {
            padding: 24px;
        }

        .room-detail-main {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .room-detail-card h2,
        .room-detail-card h3 {
            margin: 0 0 14px;
            color: var(--surface-dark);
        }

        .room-detail-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .room-detail-meta {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .room-detail-list {
            display: grid;
            gap: 10px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .room-detail-list li {
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255, 250, 244, 0.72);
            border: 1px solid rgba(35, 83, 71, 0.08);
            color: var(--surface-dark);
        }

        .room-detail-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: auto;
            padding-top: 24px;
            justify-content: flex-end;
        }

        @media (max-width: 900px) {
            .room-detail-grid {
                grid-template-columns: 1fr;
            }

            .room-detail-cover {
                min-height: 300px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="room-detail-layout">
        <article class="panel room-detail-hero">
            <div class="room-detail-cover room-image room-image--{{ $room->theme }}">
                <div>
                    <span class="eyebrow">{{ $room->availability_label }}</span>
                    <h1>{{ $room->name }}</h1>
                    <p>{{ $room->location }}</p>
                </div>

                <div class="room-detail-pills">
                    <span class="room-detail-pill">{{ $room->capacity_label }}</span>
                    <span class="room-detail-pill">{{ $room->size_label }}</span>
                    <span class="room-detail-pill">{{ $room->price_display }} {{ $room->period_display }}</span>
                </div>
            </div>
        </article>

        <div class="room-detail-grid">
            <section class="panel room-detail-card room-detail-main">
                <h2>Room Information</h2>
                <p>{{ $room->description }}</p>

                <div class="room-detail-meta">
                    <div class="meta-line">
                        <span>Room type</span>
                        <strong>{{ $room->room_type ?: 'Standard room' }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Status</span>
                        <strong>{{ ucfirst($room->status) }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Location</span>
                        <strong>{{ $room->location }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Deposit</span>
                        <strong>{{ $room->deposit_display }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Bathroom</span>
                        <strong>{{ $room->bathroom }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Furnishing</span>
                        <strong>{{ $room->furnishing }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Available from</span>
                        <strong>{{ $room->available_from_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Utilities</span>
                        <strong>{{ $room->utilities_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Contract</span>
                        <strong>{{ $room->contract_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Availability</span>
                        <strong>{{ $room->availability_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Capacity</span>
                        <strong>{{ $room->capacity_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Size</span>
                        <strong>{{ $room->size_label }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Rent</span>
                        <strong>{{ $room->price_display }} {{ $room->period_display }}</strong>
                    </div>
                </div>

                <div class="room-detail-header-actions">
                    <a href="{{ route('home') }}#featured-rooms" class="button-secondary">Back to Rooms</a>
                </div>

            </section>

            <div class="room-detail-layout">
                <section class="panel room-detail-card">
                    <h3>Amenities</h3>
                    <ul class="room-detail-list">
                        @foreach ($room->amenities_list as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </section>

                <section class="panel room-detail-card">
                    <h3>Policies</h3>
                    <ul class="room-detail-list">
                        @foreach ($room->policies_list as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </section>

                <section class="panel room-detail-card">
                    <h3>Booking Request</h3>
                    <form action="{{ route('booking.request') }}" method="POST" class="form-grid">
                        @csrf
                        <input type="hidden" name="room_slug" value="{{ $room->slug }}">

                        <div class="field">
                            <label for="guest_name">Full name</label>
                            <input id="guest_name" type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name ?? '') }}" required>
                        </div>

                        <div class="field">
                            <label for="guest_email">Email address</label>
                            <input id="guest_email" type="email" name="guest_email" value="{{ old('guest_email', auth()->user()->email ?? '') }}" required>
                        </div>

                        <div class="field">
                            <label for="guest_phone">Phone number</label>
                            <input id="guest_phone" type="text" name="guest_phone" value="{{ old('guest_phone', optional(auth()->user()?->customerProfile)->phone) }}">
                        </div>

                        <div class="form-row-two">
                            <div class="field">
                                <label for="move_in_date">Move-in date</label>
                                <input id="move_in_date" type="date" name="move_in_date" value="{{ old('move_in_date') }}">
                            </div>

                            <div class="field">
                                <label for="duration_value">Duration</label>
                                <input id="duration_value" type="number" min="1" name="duration_value" value="{{ old('duration_value') }}" placeholder="6">
                            </div>
                        </div>

                        <div class="field">
                            <label for="duration_unit">Duration unit</label>
                            <select id="duration_unit" name="duration_unit">
                                @foreach (['days' => 'Days', 'weeks' => 'Weeks', 'months' => 'Months'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('duration_unit', 'months') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" rows="4" placeholder="Move-in preference, budget notes, or special requests">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="button-submit">Submit Request</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
