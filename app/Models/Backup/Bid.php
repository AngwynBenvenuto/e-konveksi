<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bid';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

}
