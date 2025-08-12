<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'tb_users'; 

    protected $primaryKey = 'username'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    public $timestamps = false;

    protected $fillable = ['username', 'email','password', 'level', 'kode_unit', 'created_at','update_at'];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, "kode_unit", "kode_unit");
    }
}
