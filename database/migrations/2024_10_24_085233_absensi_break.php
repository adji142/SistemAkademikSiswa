<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AbsensiBreak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_break', function (Blueprint $table) {
            $table->id();
            $table->string('sn');
            $table->string('pin');
            $table->datetime('scan_in');
            $table->datetime('scan_out');
            $table->integer('verifymode');
            $table->integer('inoutmode');
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
        Schema::dropIfExists('absensi_break');
    }
}
