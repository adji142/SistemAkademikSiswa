<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // Kolom ID (auto-increment)
            $table->string('name'); // Nama izin
            $table->string('description')->nullable(); // Deskripsi izin
            $table->integer('level')->default(1); // Level izin
            $table->integer('order')->default(0); // Urutan izin
            $table->string('RecordOwnerID'); // Kolom untuk RecordOwnerID
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
        Schema::dropIfExists('permissions');
    }
}
