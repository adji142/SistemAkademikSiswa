<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Siswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('NISN')->primary();
            $table->string('NIK')->unique();
            $table->integer('PINAbsensi')->unique();
            $table->string('NamaSiswa');
            $table->string('JenisKelamin');
            $table->string('TempatLahir');
            $table->string('TanggalLahir');
            $table->string('AlamatSiswa');
            $table->integer('ProvID');
            $table->integer('KotaID');
            $table->integer('KecID');
            $table->integer('KelID');
            $table->integer('KelasID');
            $table->integer('KelasParalelID');
            $table->string('Email')->unique();
            $table->string('NoHP')->unique();
            $table->string('tempStore');
            $table->integer('tahunajaran');
            $table->string('Foto');
            $table->integer('Status')->default(0); // 1: Uploaded
            $table->string('NamaWali');
            $table->string('HubunganWali');
            $table->string('AlamatWali');
            $table->integer('WaliProvID');
            $table->integer('WaliKotaID');
            $table->integer('WaliKecID');
            $table->integer('WaliKelID');
            $table->string('NoTlpWali');
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
        Schema::dropIfExists('siswa');
    }
}
