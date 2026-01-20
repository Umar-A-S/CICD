<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('wilayah_tujuan')->nullable();
            $table->string('wilayah')->nullable();
            $table->string('daerah_tujuan')->nullable();
            $table->string('daerah_asal')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_permohonans');
    }
};
