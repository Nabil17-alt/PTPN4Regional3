<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianApproval extends Model
{
    protected $table = 'pembelian_approvals';

    protected $fillable = [
        'pembelian_id',
        'role',
        'harga_penetapan',
        'harga_escalasi',
        'approved_by',
        'approved_at',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
