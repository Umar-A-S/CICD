<x-layout-superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Flash Messages -->
    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i>
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center gap-3">
            <i class="fa-solid fa-exclamation-circle"></i>
            {{ $message }}
        </div>
    @endif

    <!-- HEADER WITH ACTION -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Daftar User ({{ $users->total() }})</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola semua pengguna sistem SELAKSA</p>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="flex items-center gap-2 bg-lime-400 text-black px-6 py-2.5 rounded-lg hover:bg-lime-500 font-bold transition">
            <i class="fa-solid fa-plus"></i>
            Tambah User
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="glass-panel rounded-xl overflow-hidden">

            <!-- TABLE HEADER -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-lime-300 text-black text-sm uppercase font-bold">
                        <tr>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Kode Wilayah</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $user->username }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if ($user->role === 'daerah')
                                            bg-blue-100 text-blue-800
                                        @elseif ($user->role === 'provinsi')
                                            bg-purple-100 text-purple-800
                                        @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->kode_wilayah ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3 text-lg">
                                        <a href="{{ route('superadmin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-800 transition" title="Lihat">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fa-solid fa-inbox text-4xl mb-3 opacity-50"></i>
                                    <p>Tidak ada data user</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            @if($users->hasPages())
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

</x-layout-superadmin>
