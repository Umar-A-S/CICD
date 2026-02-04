<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::where('role', '!=', 'superadmin')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('superadmin.users.index', [
            'title' => 'Manajemen User',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        // Load kabupaten/kota Jawa Tengah untuk dropdown name
        $kabupatenJateng = $this->getKabupatenJateng();
        
        return view('superadmin.users.create', [
            'title' => 'Tambah User',
            'roles' => ['daerah' => 'User Daerah', 'provinsi' => 'User Provinsi'],
            'wilayahOptions' => $this->getWilayahOptions(),
            'kabupatenJateng' => $kabupatenJateng
        ]);
    }

    /**
     * Get list kabupaten/kota di Jawa Tengah dari JSON
     */
    private function getKabupatenJateng()
    {
        $jsonPath = public_path('data/kota_kabupaten.json');
        
        if (!file_exists($jsonPath)) {
            return [];
        }
        
        $data = json_decode(file_get_contents($jsonPath), true);
        
        // Return kabupaten/kota Jawa Tengah yang sudah sorted
        return isset($data['Jawa Tengah']) 
            ? collect($data['Jawa Tengah'])->sort()->values()->toArray()
            : [];
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:daerah,provinsi',
            'kode_wilayah' => 'required_if:role,daerah|nullable|string|max:10',
        ], [
            'username.unique' => 'Username sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kode_wilayah.required_if' => 'Kode Wilayah harus diisi untuk User Daerah.',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'kode_wilayah' => $validated['kode_wilayah'] ?? null,
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Prevent viewing superadmin accounts
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak bisa melihat akun superadmin.');
        }

        return view('superadmin.users.show', [
            'title' => 'Detail User',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Prevent editing superadmin accounts
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak bisa mengedit akun superadmin.');
        }

        return view('superadmin.users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => ['daerah' => 'User Daerah', 'provinsi' => 'User Provinsi'],
            'wilayahOptions' => $this->getWilayahOptions()
        ]);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent updating superadmin accounts
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak bisa mengubah akun superadmin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:daerah,provinsi',
            'kode_wilayah' => 'required_if:role,daerah|nullable|string|max:10',
        ], [
            'username.unique' => 'Username sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kode_wilayah.required_if' => 'Kode Wilayah harus diisi untuk User Daerah.',
        ]);

        try {
            $user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'role' => $validated['role'],
                'kode_wilayah' => $validated['kode_wilayah'] ?? null,
            ]);

            // Update password hanya jika ada input
            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            return redirect()->route('superadmin.users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified user (Soft Delete / Archive)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting superadmin accounts
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak bisa menghapus akun superadmin.');
        }

        // Soft delete: just mark as inactive or really delete
        try {
            $user->delete();
            return redirect()->route('superadmin.users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Helper: Get wilayah options (Kota/Kabupaten di Jawa Tengah)
     */
    private function getWilayahOptions()
    {
        return [
            '33.01' => 'Kabupaten Cilacap',
            '33.02' => 'Kabupaten Banyumas',
            '33.03' => 'Kabupaten Purbalingga',
            '33.04' => 'Kabupaten Demak',
            '33.05' => 'Kabupaten Batang',
            '33.06' => 'Kabupaten Kendal',
            '33.07' => 'Kabupaten Semarang',
            '33.08' => 'Kabupaten Magelang',
            '33.09' => 'Kabupaten Wonogiri',
            '33.10' => 'Kabupaten Sukoharjo',
            '33.11' => 'Kabupaten Boyolali',
            '33.12' => 'Kabupaten Klaten',
            '33.13' => 'Kabupaten Karanganyar',
            '33.14' => 'Kabupaten Sragen',
            '33.15' => 'Kabupaten Rembang',
            '33.16' => 'Kabupaten Pati',
            '33.17' => 'Kabupaten Kudus',
            '33.18' => 'Kabupaten Jepara',
            '33.19' => 'Kabupaten Blora',
            '33.20' => 'Kabupaten Brebes',
            '33.74' => 'Kota Magelang',
            '33.75' => 'Kota Surakarta',
            '33.76' => 'Kota Salatiga',
            '33.77' => 'Kota Semarang',
            '33.78' => 'Kota Pekalongan',
            '33.79' => 'Kota Tegal',
        ];
    }
}
