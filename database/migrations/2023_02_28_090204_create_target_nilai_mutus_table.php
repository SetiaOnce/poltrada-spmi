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
        Schema::create('target_nilai_mutu', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('lembaga_akreditasi_id');
            $table->integer('unit_prodi_id');
            $table->integer('target_nilai');
            $table->string('keterangan');
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
        Schema::dropIfExists('target_nilai_mutus');
    }
};
