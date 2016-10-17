<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    //
    protected $fillable =['check_in', 'check_out', 'date', 'working_hour', 'late' ,'present'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}
