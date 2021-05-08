<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function province() {
        return $this->belongsTo(Province::class);
    }
}
