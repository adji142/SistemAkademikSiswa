<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemplateMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templatemessage', function (Blueprint $table) {
            $table->id();
            $table->string('NamaTemplate');
            $table->text('TemplateContent');
            $table->integer('IntervalHour')->nullable();
            $table->string('CronJobScript')->nullable();
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
        Schema::dropIfExists('templatemessage');
    }
}
