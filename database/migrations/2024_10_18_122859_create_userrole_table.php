<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrole', function (Blueprint $table) {
            $table->id(); // Kolom ID (auto-increment)
            $table->foreignId('userid')->constrained('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->foreignId('roleid')->constrained('roles')->onDelete('cascade'); // Foreign key ke tabel roles
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
        Schema::dropIfExists('userrole');
    }
}
