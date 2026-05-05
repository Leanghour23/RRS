@props([
    'variant' => 'default',
    'label' => 'Stay Safe Here',
    'markClass' => '',
])

@php
    $isLight = $variant === 'light';
    $stroke = $isLight ? 'rgba(255,250,244,0.92)' : '#183a37';
    $fill = $isLight ? 'rgba(255,250,244,0.18)' : '#fff7f0';
    $accent = $isLight ? '#f7c4ad' : '#bf6d4d';
@endphp

<span {{ $attributes->class(['site-logo', $isLight ? 'site-logo-light' : 'site-logo-default']) }}>
    <span class="{{ trim('site-logo-mark ' . $markClass) }}" aria-hidden="true">
        <svg viewBox="0 0 64 64" role="img" focusable="false">
            <rect x="6" y="6" width="52" height="52" rx="18" fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="2.5" />
            <path d="M20 35.5L32 24l12 11.5" fill="none" stroke="{{ $stroke }}" stroke-width="3.25" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M24.5 33.5V43h15V33.5" fill="none" stroke="{{ $stroke }}" stroke-width="3.25" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M18 45.5c4.5-3.2 8.8-4.8 14-4.8s9.5 1.6 14 4.8" fill="none" stroke="{{ $accent }}" stroke-width="3" stroke-linecap="round" />
            <circle cx="45.5" cy="20" r="3.5" fill="{{ $accent }}" />
        </svg>
    </span>
    <span class="site-logo-wordmark">{{ $label }}</span>
</span>
