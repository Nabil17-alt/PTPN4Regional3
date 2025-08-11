<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tb_pembelian_cpo_pk';

    protected $primaryKey = 'kode_unit';
    public $incrementing = false;

    public $timestamps = true;
    protected $keyType = 'string';
    public function getRouteKeyName()
    {
        return 'kode_unit';
    }

    protected $fillable = [
        'kode_unit',
        'tanggal',
        'grade',
        'harga_cpo',
        'harga_pk',
        'rendemen_cpo',
        'rendemen_pk',
        'biaya_olah',
        'tarif_angkut_cpo',
        'tarif_angkut_pk',
        'biaya_angkut_jual',
        'harga_escalasi'
    ];
}
