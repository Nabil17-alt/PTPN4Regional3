<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relasi ke PKS (menggunakan nama_pks seperti di model Pembelian & Biaya)
            $table->string('nama_pks');

            // Tanggal transaksi pembelian
            $table->date('tanggal');

            // Informasi biaya yang digunakan
            $table->string('biaya_bulan_berapa')->nullable(); // contoh: "2025-01" atau "Januari 2025"
            $table->unsignedBigInteger('biayabulanan_id')->nullable(); // relasi ke tb_biayabulanan

            // Harga referensi CPO & PK (penetapan)
            $table->decimal('harga_cpo_penetapan', 15, 2)->nullable();
            $table->decimal('harga_pk', 15, 2)->nullable();

            // Field tambahan yang diminta, diisi dari data biaya bulanan
            $table->decimal('biaya_olah', 15, 2)->nullable();
            $table->decimal('tarif_angkut_cpo', 15, 2)->nullable();
            $table->decimal('tarif_angkut_pk', 15, 2)->nullable();

            // Per grade
            $table->string('grade', 50)->nullable();
            $table->decimal('rendemen_cpo', 8, 4)->nullable();
            $table->decimal('rendemen_pk', 8, 4)->nullable();
            $table->decimal('harga_bep', 15, 2)->nullable();
            $table->decimal('harga_penetapan', 15, 2)->nullable();
            $table->decimal('eskalasi', 8, 4)->nullable();
            $table->decimal('harga_pesaing', 15, 2)->nullable();

            $table->timestamps();

            // Opsional: foreign key ke tb_biayabulanan jika tabel itu sudah ada
            // Sesuaikan nama primary key di tb_biayabulanan bila berbeda
            // $table->foreign('biayabulanan_id')->references('id')->on('tb_biayabulanan')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian');
    }
};
