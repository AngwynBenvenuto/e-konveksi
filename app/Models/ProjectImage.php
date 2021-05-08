<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $table = 'project_image';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
   
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
