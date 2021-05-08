<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nego extends Model
{
    protected $table = 'negosiasi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function penjahit() {
        return $this->belongsTo(Penjahit::class);
    }
}
