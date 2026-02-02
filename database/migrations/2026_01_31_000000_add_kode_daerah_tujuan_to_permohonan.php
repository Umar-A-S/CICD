<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('kode_daerah_tujuan')->nullable()->after('daerah_tujuan');
        });

        // Backfill existing data
        DB::statement('
            UPDATE permohonan p
            INNER JOIN users u ON p.daerah_tujuan = u.name
            SET p.kode_daerah_tujuan = u.kode_wilayah
        ');
    }

    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('kode_daerah_tujuan');
        });
    }
};
