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
        Schema::create('jenis_standar_mutu', function (Blueprint $table) {
            $table->id();
            $table->integer('daftar_standar_mutu_id');
            $table->integer('tahun');
            $table->integer('lembaga_akreditasi_id');
            $table->integer('unit_prod_id');
            $table->string('jenis_standar_mutu');
            $table->string('data_dukung');
            $table->string('keterangan');
            $table->string('jenis_indikator');
            $table->string('bobo_nilai');
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
        Schema::dropIfExists('jenis_standar_mutus');
    }
};
