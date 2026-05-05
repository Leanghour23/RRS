@props([
    'name',
])

<svg {{ $attributes->class(['admin-menu-icon']) }} viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($name)
        @case('home')
            <path d="M3 10.5L12 3l9 7.5" />
            <path d="M5.5 9.5V20h13V9.5" />
            <path d="M10 20v-5h4v5" />
            @break

        @case('dashboard')
            <rect x="4" y="4" width="7" height="7" rx="1.5" />
            <rect x="13" y="4" width="7" height="5" rx="1.5" />
            <rect x="13" y="11" width="7" height="9" rx="1.5" />
            <rect x="4" y="13" width="7" height="7" rx="1.5" />
            @break

        @case('bookings')
            <rect x="4" y="5" width="16" height="15" rx="2" />
            <path d="M8 3v4M16 3v4M4 10h16" />
            <path d="M8 14h3M13 14h3M8 17h8" />
            @break

        @case('customers')
            <path d="M16 20v-1a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v1" />
            <circle cx="10" cy="8" r="4" />
            <path d="M16 11a3.5 3.5 0 0 1 0 7" />
            @break

        @case('inventory')
            <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
            <path d="M12 12l8-4.5M12 12L4 7.5M12 12v9" />
            @break
    @endswitch
</svg>
