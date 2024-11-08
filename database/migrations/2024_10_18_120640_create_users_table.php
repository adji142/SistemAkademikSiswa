<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom ID (auto-increment)
            $table->string('name'); // Kolom untuk nama
            $table->string('email')->unique(); // Kolom untuk email (unik)
            $table->string('password'); // Kolom untuk password
            $table->string('RecordOwnerID'); // Kolom untuk RecordOwnerID
            $table->string('BranchID')->nullable(); // Kolom untuk BranchID, bisa null
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
