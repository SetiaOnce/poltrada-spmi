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
        Schema::create('profile_spmi', function (Blueprint $table) {
            $table->id();
            $table->text('visi_misi');
            $table->text('fungsi_tugas');
            $table->string('struktur_organisasi');
            $table->text('deskrip_struktur');
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
        Schema::dropIfExists('profile_s_p_m_i_s');
    }
};
