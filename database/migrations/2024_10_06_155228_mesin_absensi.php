<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MesinAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesinabsensi', function (Blueprint $table) {
            $table->id();
            $table->string('NamaMesin');
            $table->string('SerialNumber');
            $table->string('ActivationCode');
            $table->string('APIToken');
            $table->string('CloudKey');
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
        Schema::dropIfExists('mesinabsensi');
    }
}
