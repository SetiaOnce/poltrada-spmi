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
        Schema::create('daftar_standar_mutu', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('lembaga_akreditasi_id');
            $table->integer('unit_prodi_id');
            $table->string('nama_standar');
            $table->string('data_dukung');
            $table->string('keterangan');
            $table->string('jenis_indikator');
            $table->integer('bobot_nilai');
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
        Schema::dropIfExists('daftar_standar_mutus');
    }
};
