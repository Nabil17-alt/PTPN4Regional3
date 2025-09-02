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

        DB::table('tb_unit')->insert([
            ['id_unit' => '6', 'kode_unit' => '3E06', 'nama_unit' => 'Kebun Plasma/Pembelian SGO/SPA/SGH', 'nama_distrik' => '', 'jenis' => 'Kebun Inti', 'singkatan' => ''],
            ['id_unit' => '7', 'kode_unit' => '3E07', 'nama_unit' => 'Kebun Plasma/Pembelian TPU/TME', 'nama_distrik' => '', 'jenis' => 'Kebun Inti', 'singkatan' => ''],
            ['id_unit' => '12', 'kode_unit' => '3E12', 'nama_unit' => 'Kebun Plasma/Pembelian SBT/LDA', 'nama_distrik' => '', 'jenis' => 'Kebun Inti', 'singkatan' => ''],
            ['id_unit' => '25', 'kode_unit' => '3E25', 'nama_unit' => 'Kebun Plasma/Pembelian STA/SSI/SIN/SRO', 'nama_distrik' => '', 'jenis' => 'Kebun Inti', 'singkatan' => ''],
            ['id_unit' => '49', 'kode_unit' => '3R00', 'nama_unit' => 'Kantor Regional', 'nama_distrik' => '', 'jenis' => 'Kantor Regional', 'singkatan' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_unit');
    }
};
