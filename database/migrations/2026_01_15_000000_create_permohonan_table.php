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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_subjek');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->enum('wilayah', ['dalam', 'luar']);
            $table->string('wilayah_tujuan');
            $table->string('daerah_tujuan');    
            $table->string('daerah_asal');
            $table->string('jenis_permohonan');
            $table->string('jenis_dokumen');
            $table->string('file_path');
            $table->enum('status', ['BELUM', 'DIPROSES', 'DITOLAK', 'SELESAI'])->default('BELUM');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan');
    }
};
