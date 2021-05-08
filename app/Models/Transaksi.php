<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function penjahit() {
        return $this->belongsTo(Penjahit::class);
    }

    public function review() {
        return $this->hasMany(Review::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

     public function project_data() {
        return $this->hasMany(ProjectData::class);
    }
}
