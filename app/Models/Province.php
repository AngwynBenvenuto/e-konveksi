<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function country() {
        return $this->belongsTo(Country::class);
    }
}
