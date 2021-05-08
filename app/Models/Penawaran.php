<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'offers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function penjahit() {
        return $this->belongsTo(Penjahit::class);
    }

}