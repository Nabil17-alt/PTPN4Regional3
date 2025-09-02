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
            $table->string('password');
            $table->enum('level', ['Admin', 'Asisten', 'Manager', 'General_Manager', 'Region_Head',]);
            $table->string('kode_unit');
            $table->timestamps();
        });

        DB::table('tb_users')->insert([
            'username' => 'admin',
            'password' => Hash::make('123456'), 
            'level' => 'Admin',
            'kode_unit' => '3R00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_users');
    }
};
