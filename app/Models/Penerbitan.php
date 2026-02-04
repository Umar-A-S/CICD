<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbitan extends Model
{
    use HasFactory;

    protected $table = 'penerbitan';

    protected $fillable = [
        'permohonan_id',
        'nomor_surat_selesai',
        'tanggal_surat_selesai',
        'file_path',
        'hasil',
    ];

    protected $casts = [
        'tanggal_surat_selesai' => 'datetime',
    ];

    /**
     * Relationship: Penerbitan belongs to Permohonan
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
