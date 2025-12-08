<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pks', function (Blueprint $table) {
            $table->string('kode_pks');
            $table->string('nama_pks');
            $table->timestamps();
        });

        DB::table('tb_pks')->insert([
            ['kode_pks' => '3E06', 'nama_pks' => 'Sei Garo'],
            ['kode_pks' => '3E06', 'nama_pks' => 'Sei Pagar'],
            ['kode_pks' => '3E06', 'nama_pks' => 'Sei Galuh'],
            ['kode_pks' => '3E07', 'nama_pks' => 'Tanah Putih'],
            ['kode_pks' => '3E07', 'nama_pks' => 'Tanjung Medan'],
            ['kode_pks' => '3E12', 'nama_pks' => 'Sei Buatan'],
            ['kode_pks' => '3E12', 'nama_pks' => 'Lubuk Dalam'],
            ['kode_pks' => '3E25', 'nama_pks' => 'Sei Tapung'],
            ['kode_pks' => '3E25', 'nama_pks' => 'Sei Intan'],
            ['kode_pks' => '3E25', 'nama_pks' => 'Sei Sijenggung'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pks');
    }
};
