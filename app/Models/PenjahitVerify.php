<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjahitVerify extends Model
{
    protected $table = 'penjahit_verify';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function penjahit() {
        return $this->belongsTo('App\Models\Penjahit', 'penjahit_id');
    }

}