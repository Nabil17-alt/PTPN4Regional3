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
        Schema::create('tb_pembelian_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('tb_pembelian_cpo_pk')->cascadeOnDelete();
            $table->string('role');
            $table->decimal('harga_penetapan', 15, 2)->nullable();
            $table->decimal('harga_escalasi', 15, 2)->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('tb_users')->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_approvals');
    }
};
