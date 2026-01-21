<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('nama_subjek');
            $table->date('tanggal_surat');
            $table->timestamp('tanggal_permohonan');
            $table->string('wilayah')->nullable();
            $table->string('wilayah_tujuan');
            $table->string('daerah_tujuan')->nullable();
            $table->string('daerah_asal')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['BELUM', 'DIPROSES', 'DITOLAK','SELESAI'])->default('BELUM');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_permohonans');
    }
};
