<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'tb_grade'; 
    protected $fillable = ['nama_grade', 'jenis', 'created_at'];
    public $timestamps = false; 
}
