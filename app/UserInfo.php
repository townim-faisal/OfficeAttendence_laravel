<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $table = 'userinfos';

    protected $filled = ['first_name', 'last_name', 'designation'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
