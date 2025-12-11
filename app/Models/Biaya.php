<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'tb_biayabulanan';

    protected $fillable = [
        'nama_pks',
        'bulan',
        'biaya_olah',
        'tarif_angkut_cpo',
        'tarif_angkut_pk',
        'b_produksi_per_tbs_olah',
        'biaya_angkut_jual',
    ];
}
