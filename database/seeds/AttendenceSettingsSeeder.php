<?php

use Illuminate\Database\Seeder;

use App\AttendenceSettings;

class AttendenceSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $attendence_settings = new AttendenceSettings;
        $attendence_settings->total_work_hour = '09:00:00';
        $attendence_settings->arrival_time = '09:00:00';
        $attendence_settings->cron_time = '21:00';
        $attendence_settings->check_out_fixed = '18:00:00';
        $attendence_settings->save();
    }
}
