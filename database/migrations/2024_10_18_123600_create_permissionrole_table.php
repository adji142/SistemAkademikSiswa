<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissionrole', function (Blueprint $table) {
            $table->id(); // Kolom ID (auto-increment)
            $table->foreignId('roleid')->constrained('roles')->onDelete('cascade'); // Foreign key ke tabel roles
            $table->foreignId('permissionid')->constrained('permissions')->onDelete('cascade'); // Foreign key ke tabel permissions
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
        Schema::dropIfExists('permissionrole');
    }
}
