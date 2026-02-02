@php
    // Sidebar untuk superadmin
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

        <x-nav-link 
            href="{{ route('superadmin.dashboard') }}" 
            icon="fa-solid fa-chart-line"
            route="superadmin.dashboard">
            Dashboard
        </x-nav-link>

        <x-nav-link
            href="{{ route('superadmin.users.index') }}"
            icon="fa-solid fa-users"
            route="superadmin.users.*">
            Manajemen User
        </x-nav-link>

        <x-nav-link
            href="{{ route('superadmin.permohonan.index') }}"
            icon="fa-solid fa-file-lines"
            route="superadmin.permohonan.*">
            Monitor Permohonan
        </x-nav-link>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg 
                    text-red-600 hover:bg-red-50 transition font-medium text-sm">
                <i class="fa-solid fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
