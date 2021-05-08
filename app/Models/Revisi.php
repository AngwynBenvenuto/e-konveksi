<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = 'revisi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // public function transaksi() {
    //     return $this->belongsTo(Transaksi::class, 'id', 'transaction_id');
    // }
}
