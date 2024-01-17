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
        Schema::create('nama_standar_mutu', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis_standar_mutu_id');
            $table->integer('tahun');
            $table->integer('lembaga_akreditasi_id');
            $table->integer('unit_prodi_id');
            $table->string('nama_standar_mutu');
            $table->string('data_dukung');
            $table->string('keterangan');
            $table->string('jenis_indikator');
            $table->string('bobot_nilai');
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
        Schema::dropIfExists('nama_standar_mutus');
    }
};
