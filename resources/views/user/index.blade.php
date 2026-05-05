@extends('layouts.master')

@section('title', 'Stay Safe Here | Room Rental Home')
@section('page_class', 'page-home')

@section('content')
    <section class="hero">
        <div class="panel hero-copy">
            <span class="eyebrow">Modern Room Rental System</span>
            <h1>Find a room that felt like home.</h1>

            <div class="hero-actions">
                @guest
                    <a href="{{ route('register') }}" class="button-secondary">Create Account</a>
                @endguest
            </div>
        </div>
    </section>

    <section id="featured-rooms ">
        <div class="section-heading">
            <div>
                <span class="eyebrow ">
                    Room Catalog
                </span>
                <h2> Rooms designed for different renter needs.</h2>
            </div>
            <p>Live inventory from the room catalog.</p>
        </div>

        <div class="room-grid">
            @forelse ($rooms as $room)
                <article class="room-card">
                    <div
                        class="room-image room-image--{{ $room->theme }}"
                        @if ($room->image_url)
                            style="background-image: linear-gradient(180deg, rgba(24, 58, 55, 0.16), rgba(24, 58, 55, 0.52)), url('{{ $room->image_url }}'); background-position: center; background-size: cover;"
                        @endif
                    >
                        <small>{{ $room->availability_label }}</small>
                        <small>{{ $room->size_label }}</small>
                    </div>

                    <div class="room-body">
                        <div class="room-title-row">
                            <div>
                                <h3>{{ $room->name }}</h3>
                                <p class="muted">{{ $room->location }}</p>
                            </div>
                            <span class="soft-chip">{{ $room->capacity_label }}</span>
                        </div>

                        <div class="room-meta">
                            <div class="meta-line">
                                <span>Wi-Fi & utilities</span>
                                <strong>{{ $room->utilities_label }}</strong>
                            </div>
                            <div class="meta-line">
                                <span>Visit scheduling</span>
                                <strong>{{ $room->visit_label }}</strong>
                            </div>
                            <div class="meta-line">
                                <span>Contract type</span>
                                <strong>{{ $room->contract_label }}</strong>
                            </div>
                        </div>

                        <div class="price-tag">
                            <div class="price-value">
                                <strong>{{ $room->price_display }}</strong>
                                <span>{{ $room->period_display }}</span>
                            </div>
                            <a href="{{ route('rooms.show', $room->slug) }}" class="button-secondary">
                                More
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <article class="panel" style="padding: 24px;">
                    <h3 style="margin: 0 0 10px;">No rooms available yet</h3>
                    <p class="muted">Seed the catalog to start publishing listings.</p>
                </article>
            @endforelse
        </div>
    </section>
@endsection
