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
        Schema::create('pembelian_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_id'); // relasi ke pembelian
            $table->string('role'); // manager, admin, gm, rh
            $table->decimal('harga_penetapan', 15, 2)->nullable();
            $table->decimal('harga_escalasi', 15, 2)->nullable();
            $table->unsignedBigInteger('approved_by')->nullable(); // user yg approve
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('pembelian_id')->references('id')->on('tb_pembelian_cpo_pk')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
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
