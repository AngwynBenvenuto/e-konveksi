<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function ikm() {
        return $this->belongsTo(Ikm::class);
    }

    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}
