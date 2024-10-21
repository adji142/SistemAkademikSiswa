<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Guru extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->string('NIK')->primary();
            $table->string('NamaGuru');
            $table->string('Email');
            $table->string('NoHP');
            $table->integer('KelasID')->nullable(); // Jika Terisi maka di list di beri tanda dengan warna / keterangan kalau guru ini wali kelas sesuai kelas yang dipilih
            $table->integer('MapelID');
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
        Schema::dropIfExists('guru');
    }
}
