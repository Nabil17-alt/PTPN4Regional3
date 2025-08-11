<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_unit', function (Blueprint $table) {
            $table->id('id_unit'); 
            $table->string('kode_unit', 10);
            $table->string('nama_unit', 255);
            $table->string('nama_distrik', 255)->nullable();
            $table->string('jenis', 100);
            $table->string('singkatan', 100)->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_unit');
    }
};
