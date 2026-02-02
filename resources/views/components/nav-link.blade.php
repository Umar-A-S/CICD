@props([
    'href' => '#',
    'icon' => 'fa-circle',
    'count' => null, // ⬅️ NOTIF ANGKA
    'route' => null, // ⬅️ ROUTE NAME (opsional, untuk detect active)
])

@php
    // Cek menu aktif - prioritas: route name > URL path
    if ($route) {
        // Jika route name diberikan, cek match dengan current route
        $isActive = Route::currentRouteName() === $route || 
                    str_starts_with(Route::currentRouteName(), $route . '.');
    } else {
        // Fallback ke URL path matching
        $isActive = request()->is(trim($href, '/') . '*');
    }
@endphp

<style>
    .nav-item {
        transition: all 0.3s ease;
        position: relative;
    }

    /* MENU AKTIF */
    .nav-item.active {
        background: linear-gradient(90deg, rgba(200, 238, 66, 0.35) 0%, rgba(0,0,0,0) 100%);
        color: #000000;
        font-weight: 600;
    }

    /* HOVER */
    .nav-item:not(.active):hover {
        background-color: rgba(200, 238, 66, 0.25);
        color: #000000;
    }
</style>

<a href="{{ $href }}"
   {{ $attributes->merge([
        'class' =>
        'nav-item flex items-center px-4 py-3 rounded-lg text-sm ' .
        ($isActive ? 'active' : '')
   ]) }}>

    <!-- KIRI : ICON + TEXT -->
    <div class="flex items-center gap-3 flex-1">
        <i class="fa-solid {{ $icon }} w-5 text-center"></i>
        <span>{{ $slot }}</span>
    </div>

    <!-- KANAN : NOTIF BULAT MERAH -->
    @if($count && $count > 0)
        <span
            class="min-w-[20px] h-[20px]
                   px-1
                   flex items-center justify-center
                   rounded-full
                   bg-red-500
                   text-white
                   text-[11px]
                   font-semibold">
            {{ $count > 99 ? '99+' : $count }}
        </span>
    @endif

</a>