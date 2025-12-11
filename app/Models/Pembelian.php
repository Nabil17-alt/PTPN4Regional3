<?php
// app/Models/Pembelian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tb_pembelian';

    protected $fillable = [
        'kode_unit',
        'nama_pks',
        'tanggal',
        'biaya_bulan_berapa',
        'biayabulanan_id',
        'harga_cpo_penetapan',
        'harga_pk',
        'penetapan', // ini bisa dihapus jika tidak dipakai
        'grade',
        'rendemen_cpo',
        'rendemen_pk',
        'harga_bep',
        'harga_penetapan',
        'eskalasi',
        'harga_pesaing',
    ];

    public function biayaBulanan()
    {
        return $this->belongsTo(Biaya::class, 'biayabulanan_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }
}