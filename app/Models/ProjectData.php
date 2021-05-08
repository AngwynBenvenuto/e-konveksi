<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectData extends Model
{
    protected $table = 'project_data';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
   
    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}
