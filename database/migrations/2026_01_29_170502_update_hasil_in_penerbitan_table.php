<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penerbitan', function (Blueprint $table) {
            // Pastikan tipe datanya sama dengan yang lama (misal: string)
            $table->string('hasil')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('penerbitan', function (Blueprint $table) {
            // Balikin ke kondisi awal (wajib diisi / NOT NULL)
            $table->string('hasil')->nullable(false)->change();
        });
    }
};
