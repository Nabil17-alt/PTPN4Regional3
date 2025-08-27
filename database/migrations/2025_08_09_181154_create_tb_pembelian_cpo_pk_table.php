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
        Schema::create('tb_pembelian_cpo_pk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_unit', 255);
            $table->date('tanggal');
            $table->tinyInteger('status_approval_admin')->nullable();
            $table->tinyInteger('status_approval_manager')->nullable();
            $table->tinyInteger('status_approval_gm')->nullable();
            $table->tinyInteger('status_approval_rh')->nullable();
            $table->string('grade', 50)->nullable();
            $table->float('harga_cpo')->nullable();
            $table->float('harga_pk')->nullable();
            $table->float('rendemen_cpo')->nullable();
            $table->float('rendemen_pk')->nullable();
            $table->float('biaya_olah')->nullable();
            $table->float('tarif_angkut_cpo')->nullable();
            $table->float('tarif_angkut_pk')->nullable();
            $table->float('biaya_angkut_jual')->nullable();
            $table->float('harga_escalasi')->nullable();
            $table->float('total_rendemen')->nullable();
            $table->float('pendapatan_cpo')->nullable();
            $table->float('pendapatan_pk')->nullable();
            $table->float('total_pendapatan')->nullable();
            $table->float('biaya_produksi')->nullable();
            $table->float('total_biaya')->nullable();
            $table->float('harga_penetapan')->nullable();
            $table->float('margin')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });



    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian_cpo_pk');
    }
};