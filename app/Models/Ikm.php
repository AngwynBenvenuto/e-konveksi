<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikm extends Model
{
    protected $table = 'ikm';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    //
    public function project() {
        return $this->hasMany(Project::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }
}
