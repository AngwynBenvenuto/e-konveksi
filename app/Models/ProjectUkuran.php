<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUkuran extends Model
{
    protected $table = 'project_ukuran';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function ukuran(){
        return $this->belongsTo(Ukuran::class);
    }

}
