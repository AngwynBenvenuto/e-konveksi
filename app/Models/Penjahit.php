<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penjahit extends Authenticatable
{
    use Notifiable;

    protected $table = 'penjahit';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $fillable = [
        'country_id', 'province_id', 'city_id', 'districts_id',
        'code', 'gender',
        'name', 'name_display', 'email', 'address', 'phone',
        'birthdate', 'password',
        'bank', 'account_holder', 'account_number',
        'image_name', 'image_url'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //
    public function project() {
        return $this->hasMany(Project::class);
    }

    public function penawaran() {
        return $this->hasMany(Penawaran::class);
    }

    public function penjahitAddress() {
        return $this->hasMany(PenjahitAddress::class, 'penjahit_id', 'id');
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

    public function verify() {
        return $this->hasOne(PenjahitVerify::class, 'penjahit_id', 'id');
    }

}
