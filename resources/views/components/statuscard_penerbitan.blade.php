<div id="view-penerbitan" class="fade-in">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-total">
                    {{ $permohonanPerlu->count() + $permohonanSelesai->count() }}
                </div>
                <div class="text-xs text-black uppercase">Total</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-ready">
                    {{ $permohonanPerlu->count() }}
                </div>
                <div class="text-xs text-black uppercase">Perlu Dibalas</div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-xl flex items-center gap-4 hover:bg-white/5 transition" style="background-color: #ffffff; box-shadow: 0px 4px 20px 0px rgba(0,0,0,0.20);">
            <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-black" id="stat-done">
                    {{ $permohonanSelesai->count() }}
                </div>
                <div class="text-xs text-black uppercase">Selesai</div>
            </div>
        </div>

    </div>
</div>