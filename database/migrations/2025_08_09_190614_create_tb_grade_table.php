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
        Schema::create('tb_grade', function (Blueprint $table) {
            $table->id();
            $table->string('nama_grade')->nullable();
            $table->string('jenis')->nullable();
            $table->timestamps();
        });

        DB::table('tb_grade')->insert([
            ['nama_grade' => 'Plasma (Plasma Tua)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'MBJ (Matahari Berkah Jaya)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR-E (Marga Bhakti)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Tani Makmur)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Karya Sawit)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Majapahit)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Tandan Mas Jaya)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Tunas Muda)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Budi Sawit)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Lembah Sawit)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Karya Tani)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Makarti Jaya 2019)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Makarti Jaya 2020)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Wisma Tani)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Subur Makmur)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'PSR (Gemah Ripah)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'Revit (Karya Darma III)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'Revit (Tunas Karya)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'Revit (Karya Mukti)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'Revit (Dayo Mukti)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'Revit (Tani Sejahtera)', 'jenis' => 'PLSM'],
            ['nama_grade' => 'A1', 'jenis' => 'PHTG'],
            ['nama_grade' => 'A2', 'jenis' => 'PHTG'],
            ['nama_grade' => 'A3', 'jenis' => 'PHTG'],
            ['nama_grade' => 'A1+', 'jenis' => 'PHTG'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_grade');
    }
};
