@php
    $role = $role ?? 'kota';
@endphp

<aside class="w-64 border-r flex flex-col z-20 h-full bg-white">
    <div class="p-6 flex items-center gap-3 border-b border-gray-100">
        <img class="w-8 h-8" src="img/logo_selaksa.png" alt="Logo" onerror="this.style.display='none';">
        <span class="font-bold text-lg tracking-wide text-black">SELAKSA</span>
    </div>

    <nav class="flex-1 mt-4 px-2 space-y-1 overflow-y-auto">

        @if($role === 'kota')
            <x-nav-link href="/dashboard-kota" icon="fa-house">Dashboard</x-nav-link>
            <x-nav-link href="/arsipdata-kota" icon="fa-box-archive">Arsip Data</x-nav-link>
            <x-nav-link href="/penerbitan" icon="fa-print">Penerbitan</x-nav-link>
            <x-nav-link href="/permohonan" icon="fa-file">Permohonan</x-nav-link>
            <x-nav-link href="/pengaturan" icon="fa-gear">Pengaturan</x-nav-link>
        @endif

        @if($role === 'provinsi')
            <x-nav-link href="/dashboard-provinsi" icon="fa-house">Dashboard</x-nav-link>
            <x-nav-link href="/arsipdata-provinsi" icon="fa-box-archive">Arsip Data</x-nav-link>
            <x-nav-link href="/pengaturan" icon="fa-gear">Pengaturan</x-nav-link>
        @endif

        @if($role === 'superadmin')
            <x-nav-link href="/dashboard-superadmin" icon="fa-house">Dashboard</x-nav-link>
            <x-nav-link href="/arsipdata-superadmin" icon="fa-box-archive">Arsip Data</x-nav-link>
            <x-nav-link href="/manajemenuser" icon="fa-users">Manajemen User</x-nav-link>
        @endif

    </nav>

    <div class="p-4 border-t border-gray-100">
        <a href="/" class="flex items-center gap-3 text-gray-600 hover:text-red-600 transition text-sm px-4 py-2">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>