<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendenceSettings extends Model
{
    //
    protected $table = 'attendencesettings';

    protected $filled = ['total_work_hour', 'arrival_time', 'cron_time', 'check_out_fixed'];
}
