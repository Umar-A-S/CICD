@props([
    'href' => '#',
    'icon' => 'fa-circle'
])

@php
    // Cek apakah URL saat ini cocok dengan href (otomatis jadi active)
    // Menghapus "/" di awal agar pencocokan request()->is() lebih akurat
    $isActive = request()->is(trim($href, '/') . '*');
@endphp

<style>
    .nav-item {
        transition: all 0.3s ease;
        position: relative;
    }
    /* Warna saat menu AKTIF */
    .nav-item.active {
        background: linear-gradient(90deg, rgba(200, 238, 66, 0.2) 0%, rgba(0,0,0,0) 100%);
        color: #000000;            /* text-red-700 */
        font-weight: 600;
    }
    /* Garis merah di samping saat aktif */
    /* .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        height: 60%;
        width: 4px;
        background-color: #ef4444;
        border-radius: 0 4px 4px 0;
    } */
    /* Warna saat HOVER (tidak aktif) */
    .nav-item:not(.active):hover {
        background-color: #c9ee423c; /* gray-100 */
        color: #000000;
    }
</style>

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => 'nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-sm text-black-600 ' . ($isActive ? 'active' : '')]) }}>
    
    <i class="fa-solid {{ $icon }} w-5 text-center {{ $isActive ? 'text-black' : 'text-black' }}"></i>
    <span>{{ $slot }}</span>
</a>