<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password');
            $table->enum('level', ['Admin', 'Asisten', 'Manager', 'General_Manager', 'Region_Head',]);
            $table->string('kode_unit');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_users');
    }
};
