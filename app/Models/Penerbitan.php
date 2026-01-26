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
        'tanggal_surat',
        'tanggal_selesai',
        'alasan',
        'file_path',
        'hasil',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Relationship: Penerbitan belongs to Permohonan
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
