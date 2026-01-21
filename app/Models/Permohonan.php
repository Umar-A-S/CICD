<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'permohonan';

    // Kolom yang boleh diisi (mass assignment) sesuai migrasi terbaru
    protected $fillable = [
        'jenis',
        'nama',
        'nik',
        'tanggal_surat',
        'nomor_surat',
        'wilayah_tujuan',
        'daerah_tujuan',
        'daerah_asal',
        'file_path',
        'status'
    ];
}