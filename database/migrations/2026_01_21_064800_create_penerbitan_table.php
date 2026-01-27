<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penerbitan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->onDelete('cascade');
            $table->string('nomor_surat_selesai');
            $table->timestamp('tanggal_surat_selesai');
            $table->string('alasan')->nullable();
            $table->string('file_path');
            $table->enum('hasil', ['TERCATAT', 'TIDAK TERCATAT', 'DISETUJUI', 'TIDAK DISETUJUI', 'LAINNYA']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerbitan');
    }
};
