<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public function attendences()
    {
        return $this->hasMany('App\Attendence');
    }


    public function leaves()
    {
        return $this->hasMany('App\Leave');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function userinfos()
    {
        return $this->hasMany('App\UserInfo');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    /*
    readable time for attendence table
    take the date-time string and change it as a timestamp and then formated it by $format
    */
    public function readTime($format, $time)
    {
        if(isset($time)){
            return date($format, strtotime($time));
        }else{
            return "";
        }
    }
    
    //check roles for user
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

}
