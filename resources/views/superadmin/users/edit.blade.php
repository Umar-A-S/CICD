<x-layout_superadmin>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- BREADCRUMB -->
    <div class="mb-6">
        <a href="{{ route('superadmin.users.index') }}" class="text-lime-500 hover:text-lime-600 font-semibold text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar User
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl shadow-sm p-8 max-w-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $title }}</h3>

        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <p class="font-bold mb-2"><i class="fa-solid fa-exclamation-circle"></i> Validasi Error:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-800 mb-2">
                    Nama Lengkap <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-bold text-gray-800 mb-2">
                    Username <span class="text-red-600">*</span>
                </label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400">
                <p class="text-gray-500 text-xs mt-1">ℹ️ Username untuk login</p>
                @error('username')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-bold text-gray-800 mb-2">
                    Role <span class="text-red-600">*</span>
                </label>
                <select id="role" name="role" required onchange="toggleWilayah(this.value)"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kode Wilayah (untuk User Daerah) -->
            <div id="wilayah-container" class="{{ old('role', $user->role) === 'daerah' ? '' : 'hidden' }}">
                <label for="kode_wilayah" class="block text-sm font-bold text-gray-800 mb-2">
                    Kode Wilayah <span class="text-red-600">*</span>
                </label>
                <select id="kode_wilayah" name="kode_wilayah"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400">
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach ($wilayahOptions as $kode => $nama)
                        <option value="{{ $kode }}" {{ old('kode_wilayah', $user->kode_wilayah) === $kode ? 'selected' : '' }}>
                            {{ $nama }} ({{ $kode }})
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-xs mt-1">ℹ️ Pilih wilayah untuk User Daerah</p>
                @error('kode_wilayah')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-bold text-gray-800 mb-2">
                    Password (Kosongkan jika tidak ingin diubah)
                </label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400"
                    placeholder="Minimal 6 karakter">
                <p class="text-gray-500 text-xs mt-1">ℹ️ Biarkan kosong untuk tidak mengubah password</p>
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">
                    Konfirmasi Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-400"
                    placeholder="Ulangi password">
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t">
                <button type="submit" class="flex items-center gap-2 bg-lime-400 text-black px-6 py-2.5 rounded-lg hover:bg-lime-500 font-bold transition">
                    <i class="fa-solid fa-save"></i>
                    Perbarui
                </button>
                <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-2 bg-gray-300 text-black px-6 py-2.5 rounded-lg hover:bg-gray-400 font-bold transition">
                    <i class="fa-solid fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function toggleWilayah(role) {
            const container = document.getElementById('wilayah-container');
            const input = document.getElementById('kode_wilayah');
            
            if (role === 'daerah') {
                container.classList.remove('hidden');
                input.required = true;
            } else {
                container.classList.add('hidden');
                input.required = false;
                input.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleWilayah(document.getElementById('role').value);
        });
    </script>

</x-layout_superadmin>
