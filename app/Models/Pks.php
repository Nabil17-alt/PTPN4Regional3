<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pks extends Model
{
    use HasFactory;

    protected $table = 'tb_pks';

    protected $fillable = [
        'kode_pks',
        'nama_pks',
    ];
}
