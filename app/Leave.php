<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
    protected $table = 'leaves';

    protected $filled = ['leave_date', 'leave_msg', 'is_approve'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
