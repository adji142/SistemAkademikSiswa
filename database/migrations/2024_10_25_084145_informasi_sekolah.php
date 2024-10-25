<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InformasiSekolah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasekolah', function (Blueprint $table) {
            $table->string('NPSN')->primary();
            $table->string('NamaSekolah');
            $table->string('AlamatSekolah');
            $table->string('SKPendirianSekolah');
            $table->date('TanggalSKPendirian');
            $table->string('SKIzinOperasional');
            $table->date('TanggalSKOperasional');
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
        Schema::dropIfExists('datasekolah');
    }
}
