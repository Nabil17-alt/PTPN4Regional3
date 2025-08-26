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

            $table->float('total_rendemen')->storedAs('rendemen_cpo + rendemen_pk');
            $table->float('pendapatan_cpo')->storedAs('harga_cpo * (rendemen_cpo / 100)');
            $table->float('pendapatan_pk')->storedAs('harga_pk * (rendemen_pk / 100)');
            $table->float('total_pendapatan')->storedAs('pendapatan_cpo + pendapatan_pk');
            $table->float('biaya_produksi')->storedAs('(biaya_olah / 100) * (rendemen_cpo + rendemen_pk)');
            $table->float('total_biaya')->storedAs('biaya_produksi + biaya_angkut_jual');
            $table->float('harga_penetapan')->storedAs('total_pendapatan - total_biaya');
            $table->float('margin')->storedAs('(1 - (harga_escalasi / nullif(harga_penetapan, 0))) * 100');

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
