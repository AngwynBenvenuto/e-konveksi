<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $table = 'ukuran';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function project(){
        return $this->belongsToMany(Project::class);
    }
}
