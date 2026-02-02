<x-layout_superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- <!-- WELCOME SECTION -->
    <div class="bg-gradient-to-r from-lime-400 to-green-500 rounded-2xl shadow-lg p-8 mb-8 text-black">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $authUser->name }}! 👋</h1>
                <p class="text-lg opacity-90">Kelola sistem SELAKSA dengan mudah dari dashboard ini</p>
            </div>
            <div class="hidden md:block">
                <i class="fa-solid fa-chart-line text-6xl opacity-20"></i>
            </div>
        </div>
    </div> --}}

    <!-- MAIN STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total User</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</h3>
                    <p class="text-xs text-gray-400 mt-2">
                        <span class="text-blue-600 font-semibold">{{ $userDaerah }}</span> Daerah • 
                        <span class="text-purple-600 font-semibold">{{ $userProvinsi }}</span> Provinsi
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fa-solid fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Permohonan -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Permohonan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPermohonan }}</h3>
                    <p class="text-xs text-gray-400 mt-2">
                        <span class="text-green-600 font-semibold">{{ $permohonanDalam }}</span> Dalam • 
                        <span class="text-orange-600 font-semibold">{{ $permohonanLuar }}</span> Luar
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fa-solid fa-file-lines text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Permohonan Selesai -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-lime-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Selesai</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $permohonanSelesai }}</h3>
                    <p class="text-xs text-gray-400 mt-2">
                        {{ $totalPermohonan > 0 ? number_format(($permohonanSelesai / $totalPermohonan) * 100, 1) : 0 }}% dari total
                    </p>
                </div>
                <div class="bg-lime-100 rounded-full p-4">
                    <i class="fa-solid fa-check-circle text-lime-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Penerbitan -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Penerbitan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPenerbitan }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Dokumen diterbitkan</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <i class="fa-solid fa-file-circle-check text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Permohonan by Status Chart -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-lime-500"></i>
                Status Permohonan
            </h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-3 mt-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                    <span class="text-sm text-gray-600">Menunggu: <strong>{{ $permohonanMenunggu }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-500 rounded"></div>
                    <span class="text-sm text-gray-600">Diproses: <strong>{{ $permohonanDiproses }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded"></div>
                    <span class="text-sm text-gray-600">Selesai: <strong>{{ $permohonanSelesai }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                    <span class="text-sm text-gray-600">Ditolak: <strong>{{ $permohonanDitolak }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Top Daerah Chart -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-ranking-star text-lime-500"></i>
                Top 5 Daerah Aktif
            </h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="topDaerahChart"></canvas>
            </div>
        </div>

    </div>

    <!-- RECENT ACTIVITY TABLE -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-lime-500"></i>
                Aktivitas Terbaru (10 Permohonan Terakhir)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-600">
                    <tr>
                        <th class="px-6 py-3">No. Permohonan</th>
                        <th class="px-6 py-3">Daerah Asal</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($recentPermohonan as $permohonan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono">{{ $permohonan->nomor_surat }}</code>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $permohonan->daerah_asal }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $permohonan->wilayah === 'dalam' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($permohonan->wilayah) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-bold
                                    @if ($permohonan->status === 'BELUM') bg-yellow-100 text-yellow-800
                                    @elseif ($permohonan->status === 'DIPROSES') bg-blue-100 text-blue-800
                                    @elseif ($permohonan->status === 'SELESAI') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $permohonan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $permohonan->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>
                                Belum ada permohonan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('superadmin.users.create') }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-lg transition border-l-4 border-lime-500 group">
            <div class="flex items-center gap-4">
                <div class="bg-lime-100 rounded-full p-4 group-hover:bg-lime-200 transition">
                    <i class="fa-solid fa-user-plus text-lime-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Tambah User Baru</h4>
                    <p class="text-sm text-gray-500">Daftarkan user daerah/provinsi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('superadmin.users.index') }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-lg transition border-l-4 border-blue-500 group">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 rounded-full p-4 group-hover:bg-blue-200 transition">
                    <i class="fa-solid fa-list text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Daftar User</h4>
                    <p class="text-sm text-gray-500">Kelola semua pengguna sistem</p>
                </div>
            </div>
        </a>

        <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-gray-300">
            <div class="flex items-center gap-4">
                <div class="bg-gray-100 rounded-full p-4">
                    <i class="fa-solid fa-chart-line text-gray-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Sistem Aktif</h4>
                    <p class="text-sm text-gray-500">{{ $totalUsers }} user terdaftar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Status Permohonan Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $permohonanMenunggu }},
                        {{ $permohonanDiproses }},
                        {{ $permohonanSelesai }},
                        {{ $permohonanDitolak }}
                    ],
                    backgroundColor: ['#eab308', '#3b82f6', '#22c55e', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Top Daerah Bar Chart
        const topDaerahCtx = document.getElementById('topDaerahChart').getContext('2d');
        new Chart(topDaerahCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($topDaerah as $daerah)
                        '{{ Str::limit($daerah->daerah_asal, 15) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Permohonan',
                    data: [
                        @foreach ($topDaerah as $daerah)
                            {{ $daerah->total }},
                        @endforeach
                    ],
                    backgroundColor: '#cfff00',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

</x-layout_superadmin>
