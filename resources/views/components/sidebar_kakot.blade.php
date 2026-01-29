@php
    $role = $role ?? 'kota';
    $role = $role ?? 'provinsi';

    // CONTOH NOTIF (nanti bisa dari DB)
    $notifPenerbitan = 2;
    $notifBalasan = 5;
@endphp

<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 w-48 bg-white border-r flex flex-col z-30
        transform -translate-x-full md:translate-x-0 transition-transform duration-300">

    <!-- LOGO -->
    <div class="p-6 flex items-center gap-3 border-b border-gray-100">
        <img class="w-8 h-8"
            src="img/logo_selaksa.png"
            alt="Logo"
            onerror="this.style.display='none';">
        <span class="font-bold text-lg tracking-wide text-black">
            SELAKSA
        </span>
    </div>

    <!-- MENU -->
    <nav class="flex-1 mt-4 px-2 space-y-1 overflow-y-auto">

        @if($role === 'kota')
            <x-nav-link 
                href="/dashboard_kakot" 
                icon="fa-solid fa-table-cells-large">
                Dashboard
            </x-nav-link>

            <x-nav-link
                href="{{ route('penerbitan.index') }}"
                icon="fa-print"
                :count="$notifPenerbitan">
                Penerbitan
            </x-nav-link>

            <x-nav-link 
                href="{{ route('permohonan.index') }}" 
                icon="fa-solid fa-file">
                Permohonan
            </x-nav-link>

            <x-nav-link
                href="{{ route('balasan.index') }}"
                icon="fa-pen-to-square"
                :count="$notifBalasan">
                Balasan
            </x-nav-link>

            <x-nav-link 
                href="{{ route('profil.index') }}" 
                icon="fa-solid fa-user">
                Profil
            </x-nav-link>
        @endif

        @if($role === 'provinsi')
            <x-nav-link 
                href="/dashboard_provinsi" 
                icon="fa-solid fa-grip">
                Dashboard
            </x-nav-link>

            <x-nav-link
                href="/penerbitan-provinsi"
                icon="fa-print"
                :count="$notifPenerbitan">
                Penerbitan
            </x-nav-link>

            <x-nav-link
                href="/balasan_provinsi"
                icon="fa-pen-to-square"
                :count="$notifBalasan">
                Balasan
            </x-nav-link>

            <x-nav-link 
                href="/profil-provinsi" 
                icon="fa-solid fa-user">
                Profil
            </x-nav-link>
        @endif

        @if($role === 'superadmin')
            <x-nav-link 
                href="/dashboard-superadmin" 
                icon="fa-solid fa-grip">
                Dashboard
            </x-nav-link>

            <x-nav-link 
                href="/arsipdata-superadmin" 
                icon="fa-solid fa-box-archive">
                Arsip Data
            </x-nav-link>

            <x-nav-link 
                href="/manajemenuser" 
                icon="fa-solid fa-users">
                Manajemen User
            </x-nav-link>
        @endif

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                class="w-full flex items-center gap-3 text-gray-600 hover:text-red-600 hover:bg-red-50 transition text-sm px-4 py-3 rounded-lg font-medium group">
                <i class="fa-solid fa-right-from-bracket group-hover:scale-110 transition-transform"></i>
                Logout
            </button>
        </form>
    </div>
</aside>