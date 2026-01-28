<div id="view-dashboard" class="fade-in">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <!-- TOTAL -->
        <div class="glass-panel p-5 rounded-xl flex items-center gap-4"
            style="background:#fff; box-shadow:0 4px 20px rgba(0,0,0,.20)">

            <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-invoice"></i>
            </div>

            <div>
                <div class="text-2xl font-bold text-black">
                    {{ $stat['total'] ?? 0 }}
                </div>
                <div class="text-xs text-black uppercase">
                    Total Pengajuan
                </div>
            </div>
        </div>

    </div>
</div>