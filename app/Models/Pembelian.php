<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tb_pembelian_cpo_pk';

    protected $fillable = [
        'kode_unit',
        'tanggal',
        'grade',
        'harga_cpo',
        'harga_pk',
        'rendemen_cpo',
        'rendemen_pk',
        'total_rendemen',
        'pendapatan_cpo',
        'pendapatan_pk',
        'total_pendapatan',
        'biaya_olah',
        'biaya_produksi',
        'tarif_angkut_cpo',
        'tarif_angkut_pk',
        'biaya_angkut_jual',
        'total_biaya',
        'harga_penetapan',
        'harga_escalasi',
        'margin',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }
}

