<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|array $roles
     * @return mixed
     */
    public function authorizeFlag($roles){
        if(is_array($roles)){
            return $this->hasAnyRole($roles) || false;
        }
        return $this->hasRole($roles) || false;
    }

    /**
     * @param string|array $roles
     * @return mixed
     */
    public function authorizeRoles($roles){
        if(is_array($roles)){
            return $this->hasAnyRole($roles) || abort(403, 'Unauthorized action.');
        }
        return $this->hasRole($roles) || abort(403, 'Unauthorized action.');
    }

    /**
     * Check multiple roles
     * @param array $roles
     * @return string
     */
    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn("name", $roles)->first();
    }

    /**
     * Check one role
     * @param string $role
     * @return string
     */
    public function hasRole($role){
        return null !== $this->roles()->where("name", $role)->first();
    }
}
