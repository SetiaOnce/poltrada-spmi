<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('lembaga_akreditasi_id');
            $table->integer('standar_pendidikan');
            $table->integer('standar_penelitian');
            $table->integer('standar_pengabdian');
            $table->date('priode_evaluasi_diri_awal');
            $table->date('priode_evaluasi_diri_akhir');
            $table->date('priode_visitasi_awal');
            $table->date('priode_visitasi_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periode_evaluasis');
    }
};
