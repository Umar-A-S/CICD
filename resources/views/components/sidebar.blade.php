<aside class="w-64 border-r-0 flex flex-col z-20 h-full bg-white">
    <div class="p-6 flex items-center gap-3 border-b border-white/10">
        <img class="img_selaksa" src="img/logo_selaksa.png" alt="Logo" onerror="this.style.display='none';">
        <span class="font-bold text-lg tracking-wide text-black">SELAKSA</span>
    </div>

    <nav class="flex-1 mt-4 px-2 space-y-1">

        <x-nav-link
            href="/dashboard-kota"
            menu="kota/dashboard"
            icon="fa-house">
            Dashboard
        </x-nav-link>

        <x-nav-link
            href="/arsip"
            menu="arsip"
            icon="fa-box-archive">
            Arsip Data
        </x-nav-link>

        <x-nav-link
            href="/penerbitan"
            menu="penerbitan"
            icon="fa-print">
            Penerbitan
        </x-nav-link>

        <x-nav-link
            href="/permohonan"
            menu="permohonan"
            icon="fa-file">
            Permohonan
        </x-nav-link>

        <x-nav-link
            href="/pengaturan"
            menu="pengaturan"
            icon="fa-gear">
            Pengaturan
        </x-nav-link>

    </nav>

    <div class="p-4 border-t border-white/10">
        <a href="/" class="flex items-center gap-3 text-black hover:text-red-500 transition text-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>