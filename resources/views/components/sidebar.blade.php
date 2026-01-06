<aside class="w-64 border-r-0 flex flex-col z-20 h-full" style="background-color: white">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <img class="img_selaksa" src="img/logo_selaksa.png" alt="Logo" onerror="this.style.display='none';">
            <span class="font-bold text-lg tracking-wide text-black">SELAKSA</span>
        </div>

        <nav class="flex-1 mt-4 px-2 space-y-1">
            <a href="/dashboard" onclick="switchMenu('dashboard')" id="nav-dashboard" class="nav-item active flex items-center gap-3 p-3 rounded-r-md text-sm font-medium">
                <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
            </a>
            <a href="/arsip" onclick="switchMenu('arsip')" id="nav-arsip" class="nav-item flex items-center gap-3 p-3 rounded-r-md text-sm font-medium">
                <i class="fa-solid fa-box-archive w-5 text-center"></i> Arsip Data
            </a>
            <a href="/penerbitan" onclick="switchMenu('penerbitan')" id="nav-penerbitan" class="nav-item flex items-center gap-3 p-3 rounded-r-md text-sm font-medium">
                <i class="fa-solid fa-print w-5 text-center"></i> Penerbitan
            </a>
            <a href="/permohonan" onclick="switchMenu('permohonan')" id="nav-permohonan" class="nav-item flex items-center gap-3 p-3 rounded-r-md text-sm font-medium">
                <i class="fa-solid fa-file w-5 text-center"></i> Permohonan
            </a>
            <a href="/pengaturan" onclick="switchMenu('pengaturan')" id="nav-pengaturan" class="nav-item flex items-center gap-3 p-3 rounded-r-md text-sm font-medium">
                <i class="fa-solid fa-gear w-5 text-center"></i> Pengaturan
            </a>
        </nav>

        <div class="p-4 border-t border-white/10">
            <a href="/" class="flex items-center gap-3 text-black hover:text-red-500 transition text-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </aside>