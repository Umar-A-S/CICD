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
            $table->date('tanggal_surat')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->string('alasan')->nullable();
            $table->string('file_path')->nullable();
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
