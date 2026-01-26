<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalasanProvinsi extends Model
{
    use HasFactory;

    protected $table = 'balasan_provinsi';

    protected $fillable = [
        'permohonan_id',
        'alasan_penolakan',
    ];

    /**
     * Relationship: BalasanProvinsi belongs to Permohonan
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
