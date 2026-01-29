        <header class="p-6 flex justify-between items-center z-10 border-b border-white/5 bg-white">
            <button
                id="toggleSidebar"
                class="md:hidden p-2 rounded-lg text-black hover:bg-gray-100">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <h2 id="pageTitle" class="text-2xl font-bold text-black tracking-tight">{{ $slot }}</h2>
                <p id="pageSubtitle" class="text-xs text-black/80">SELAKSA (Sinergitas Layanan Keabsahan Dokumen Pencatatan Sipil)</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-black">Admin Petugas</div>
                    <div class="text-xs text-black" id="userRoleLabel">Provinsi</div>
                </div>
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-black" style="background-color: #f5f5f5; border: 1px solid #000000;">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>