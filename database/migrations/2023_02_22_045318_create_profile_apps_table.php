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
        Schema::create('profile_app', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('footer');
            $table->string('logo_header_panjang');
            $table->string('logo_header_kecil');
            $table->string('logo_aplikasi');
            $table->string('banner_detail');
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
        Schema::dropIfExists('profile_apps');
    }
};
