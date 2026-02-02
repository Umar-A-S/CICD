<x-layout_superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- BREADCRUMB -->
    <div class="mb-6">
        <a href="{{ route('superadmin.users.index') }}" class="text-lime-500 hover:text-lime-600 font-semibold text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar User
        </a>
    </div>

    <!-- DETAIL CARD -->
    <div class="bg-white rounded-2xl shadow-sm p-8 max-w-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-8">{{ $title }}</h3>

        <div class="space-y-6">
            <!-- Nama -->
            <div class="border-b pb-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Nama Lengkap</p>
                <p class="text-lg text-gray-800 font-semibold mt-2">{{ $user->name }}</p>
            </div>

            <!-- Username -->
            <div class="border-b pb-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Username</p>
                <code class="block text-lg text-gray-800 font-semibold mt-2 bg-gray-100 px-3 py-2 rounded">{{ $user->username }}</code>
            </div>

            <!-- Role -->
            <div class="border-b pb-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Role</p>
                <div class="mt-2">
                    <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold
                        @if ($user->role === 'daerah')
                            bg-blue-100 text-blue-800
                        @elseif ($user->role === 'provinsi')
                            bg-purple-100 text-purple-800
                        @endif
                    ">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <!-- Kode Wilayah -->
            <div class="border-b pb-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kode Wilayah</p>
                <p class="text-lg text-gray-800 font-semibold mt-2">{{ $user->kode_wilayah ?? '-' }}</p>
            </div>

            <!-- Tanggal Dibuat -->
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tanggal Dibuat</p>
                <p class="text-lg text-gray-800 font-semibold mt-2">{{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-8 border-t">
            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="flex items-center gap-2 bg-lime-400 text-black px-6 py-2.5 rounded-lg hover:bg-lime-500 font-bold transition">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
            </a>
            <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini? Tindakan ini tidak bisa dibatalkan!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center gap-2 bg-red-500 text-white px-6 py-2.5 rounded-lg hover:bg-red-600 font-bold transition">
                    <i class="fa-solid fa-trash"></i>
                    Hapus
                </button>
            </form>
            <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-2 bg-gray-300 text-black px-6 py-2.5 rounded-lg hover:bg-gray-400 font-bold transition">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

</x-layout_superadmin>
