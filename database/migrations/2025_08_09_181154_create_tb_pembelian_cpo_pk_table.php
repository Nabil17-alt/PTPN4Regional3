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
        Schema::create('tb_pembelian_cpo_pk', function (Blueprint $table) {
            $table->string('kode_unit', 255);
            $table->date('tanggal');
            $table->string('grade', 50);

            $table->float('harga_cpo');
            $table->float('harga_pk');
            $table->float('rendemen_cpo');
            $table->float('rendemen_pk');
            $table->float('biaya_olah');
            $table->float('tarif_angkut_cpo');
            $table->float('tarif_angkut_pk');
            $table->float('biaya_angkut_jual');
            $table->float('harga_escalasi');

            $table->float('total_rendemen')->storedAs('rendemen_cpo + rendemen_pk');
            $table->float('pendapatan_cpo')->storedAs('rendemen_cpo * harga_cpo');
            $table->float('pendapatan_pk')->storedAs('rendemen_pk * harga_pk');
            $table->float('total_pendapatan')->storedAs('pendapatan_cpo + pendapatan_pk');

            $table->float('biaya_produksi')->storedAs('biaya_olah + tarif_angkut_cpo + tarif_angkut_pk');
            $table->float('total_biaya')->storedAs('biaya_produksi + biaya_angkut_jual');
            $table->float('harga_penetapan')->storedAs('total_biaya / total_rendemen');
            $table->float('margin')->storedAs('total_pendapatan - total_biaya');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Primary Key (gabungan jika memang seperti itu)
            $table->primary(['kode_unit','tanggal', 'grade']);
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
