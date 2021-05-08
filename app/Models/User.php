<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use Notifiable;

    protected $table = 'users';
    protected $guard = 'admin';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $fillable = [
        'role_id', 'ikm_id', 'username', 'first_name', 'last_name', 
        'email', 'password', 
        'last_request', 'last_login', 'login_count'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //
    public function roles(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    //
    public function ikm(){
        return $this->belongsTo(Ikm::class, 'ikm_id', 'id');
    }
    
    //
    public function authorizeRoles($roles) {
        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    public function hasRole($role) {
        return null !== $this->roles()->where('nama', $role)->first();
    }

}
