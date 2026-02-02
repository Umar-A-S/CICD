<!-- STATUS CARDS SUPERADMIN -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- CARD 1: Total User -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total User</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\User::where('role', '!=', 'superadmin')->count() }}
                </h3>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fa-solid fa-users text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- CARD 2: Total Permohonan -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Permohonan</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\Permohonan::count() }}
                </h3>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fa-solid fa-file-lines text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- CARD 3: Permohonan Selesai -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-lime-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Permohonan Selesai</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\Permohonan::where('status', 'SELESAI')->count() }}
                </h3>
            </div>
            <div class="bg-lime-100 rounded-full p-4">
                <i class="fa-solid fa-check-circle text-lime-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>
