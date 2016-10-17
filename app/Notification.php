<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notifications';

    protected $filled = ['noti_msg', 'is_read'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
