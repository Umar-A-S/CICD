<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'permohonan';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'nama_subjek',
        'nomor_surat',
        'tanggal_surat',
        'wilayah',
        'wilayah_tujuan',
        'daerah_tujuan',
        'kode_daerah_tujuan',
        'daerah_asal',
        'jenis_permohonan',
        'jenis_dokumen',
        'file_path',
        'status'
    ];

    // Cast untuk date
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Relationship: Permohonan belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Permohonan has one BalasanProvinsi
     */
    public function balasanProvinsi()
    {
        return $this->hasOne(BalasanProvinsi::class);
    }

    /**
     * Relationship: Permohonan has one Penerbitan
     */
    public function penerbitan()
    {
        return $this->hasOne(Penerbitan::class);
    }
}