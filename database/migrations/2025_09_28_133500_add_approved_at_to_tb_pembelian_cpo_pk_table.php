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
        Schema::table('tb_pembelian_cpo_pk', function (Blueprint $table) {
            $table->timestamp('approved_at_manager')->nullable();
            $table->timestamp('approved_at_admin')->nullable();
            $table->timestamp('approved_at_gm')->nullable();
            $table->timestamp('approved_at_rh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_pembelian_cpo_pk', function (Blueprint $table) {
            $table->dropColumn(['approved_at_manager', 'approved_at_admin', 'approved_at_gm', 'approved_at_rh']);
        });
    }
};
