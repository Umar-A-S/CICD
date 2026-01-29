<div id="view-dashboard" class="fade-in">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-total">{{ $stat['total'] ?? 0 }}</div>
                <div class="text-xs text-black uppercase">Total Pengajuan</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-pending">{{ $stat['belum'] ?? 0 }}</div>
                <div class="text-xs text-black uppercase">Belum</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-arrows-rotate"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-valid">{{ $stat['proses'] ?? 0 }}</div>
                <div class="text-xs text-black uppercase">Diproses</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-success">{{ $stat['selesai'] ?? 0 }}</div>
                <div class="text-xs text-black uppercase">Selesai</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-rejected">{{ $stat['tolak'] ?? 0 }}</div>
                <div class="text-xs text-black uppercase">Ditolak</div>
            </div>
        </div>
    </div>
</div>