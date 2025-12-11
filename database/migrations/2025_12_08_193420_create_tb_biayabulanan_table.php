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
        Schema::create('tb_biayabulanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pks');
            $table->string('bulan');
            $table->decimal('biaya_olah', 15, 2)->nullable();
            $table->decimal('tarif_angkut_cpo', 15, 2)->nullable();
            $table->decimal('tarif_angkut_pk', 15, 2)->nullable();
            $table->decimal('b_produksi_per_tbs_olah', 15, 2)->nullable();
            $table->decimal('biaya_angkut_jual', 15, 2)->nullable();
            $table->timestamps();
        });

        DB::table('tb_biayabulanan')->insert([
            'nama_pks' => 'Tanah Putih',
            'bulan' => '2025-07',
            'biaya_olah' => 294.94,
            'tarif_angkut_cpo' => 171.00,
            'tarif_angkut_pk' => 194.50,
            'b_produksi_per_tbs_olah' => 70.02,
            'biaya_angkut_jual' => 35.47,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_biayabulanan');
    }
};
