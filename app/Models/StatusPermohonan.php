<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPermohonan extends Model
{
    use HasFactory;

    protected $table = 'status_permohonans';

    protected $fillable = [
        'jenis','nama','nik','tanggal_surat','nomor_surat',
        'wilayah_tujuan','wilayah','daerah_tujuan','daerah_asal',
        'file_path','status'
    ];
}
