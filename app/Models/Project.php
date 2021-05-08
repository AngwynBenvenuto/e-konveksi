<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    //
    public function ikm() {
        return $this->belongsTo(Ikm::class);
    }

    public function images() {
        return $this->hasMany(ProjectImage::class);
    }

    public function ukuran(){
        return $this->belongsToMany(Ukuran::class)->withPivot('ukuran_id', 'qty');
    }

    public function penawaran() {
        return $this->hasMany(Penawaran::class);
    }

    //filter
    public function scopeFilter($query, $params) {
        if ( isset($params['keyword']) && trim($params['keyword'] !== '') ) {
            $query->where('name', 'LIKE', trim($params['keyword']) . '%');
        }
        if ( (isset($params['price_start']) && trim($params['price_start'] !== '')) && 
             (isset($params['price_end']) && trim($params['price_end'] !== '')) ) {
            $query->whereBetween('price', array($params['price_start'], $params['price_end']));
        }
        return $query;
    }

    // public function scopeMightAlsoLike($query) {
    //     return $query->inRandomOrder()->where('views', '>', 0)->take(5);
    // }
    
}
