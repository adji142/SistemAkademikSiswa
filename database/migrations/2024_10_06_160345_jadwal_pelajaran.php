<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JadwalPelajaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalpelajaran', function (Blueprint $table) {
            $table->id();
            $table->integer('Index');
            $table->integer('matapelajaran_id');
            $table->integer('guru_id');
            $table->time('JamMulai');
            $table->time('JamSelesai');
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
        Schema::dropIfExists('jadwalpelajaran');
    }
}
