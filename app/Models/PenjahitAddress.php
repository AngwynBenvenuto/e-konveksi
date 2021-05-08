<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjahitAddress extends Model
{
    protected $table = 'penjahit_address';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function penjahit() {
        return $this->belongsTo(Penjahit::class, 'penjahit_id');
    }
}
