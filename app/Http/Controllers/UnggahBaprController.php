<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnggahBaprController extends Controller
{
    public function upload(Request $request, $id = null)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        // validate size (<= 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return response()->json(['error' => 'File terlalu besar (max 2MB)'], 400);
        }

        // validate extension
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
            return response()->json(['error' => 'Tipe file tidak diizinkan'], 400);
        }

        $name = time() . '_' . Str::random(6) . '.' . $ext;

        // store under folder per id so we can list per applicant
        $folder = 'public/unggah_bapr/' . ($id ?? 'general');
        $path = $file->storeAs($folder, $name);

        // Storage::url requires `php artisan storage:link` to have been run in environment
        $url = Storage::url('unggah_bapr/' . ($id ?? 'general') . '/' . $name);

        return response()->json(['success' => true, 'name' => $name, 'url' => $url]);
    }

    public function destroy(Request $request)
    {
        $name = $request->input('name');
        $id = $request->input('id') ?? 'general';
        if (!$name) {
            return response()->json(['error' => 'Missing file name'], 400);
        }

        $path = 'public/unggah_bapr/' . $id . '/' . $name;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return response()->json(['success' => true]);
    }

    // return list of files for given id
    public function files(Request $request, $id = null)
    {
        $id = $id ?? 'general';
        $dir = 'public/unggah_bapr/' . $id;

        $files = [];
        if (Storage::exists($dir)) {
            $list = Storage::files($dir);
            foreach ($list as $p) {
                $basename = basename($p);
                $files[] = [
                    'name' => $basename,
                    'url' => Storage::url('unggah_bapr/' . $id . '/' . $basename)
                ];
            }
        }

        return response()->json(['files' => $files]);
    }
}
