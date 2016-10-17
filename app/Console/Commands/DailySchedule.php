<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Attendence;
use App\AttendenceSettings;
use DB;

class DailySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'those who are forget to check out, their check out will be updated & those who are absent, their attendence will be created as an absent';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //those who are forget to check out, their check out will be updated
        $attendence_settings = AttendenceSettings::find(1);
        $check_outs = Attendence::whereNull("check_out")->get();
        foreach($check_outs as $check_out) {
            $check_out->check_out = date('Y-m-d ', strtotime('-1 day')) . $attendence_settings->check_out_fixed;
            $check_out->working_hour = gmdate('H:i:s', (strtotime($check_out->check_out)-strtotime($check_out->check_in)));
            $check_out->save();
        }

        //those who are absent, their attendence will be created as an absent 
        $current_users = DB::table('attendences')->where('date', date('Y-m-d', strtotime('-1 day')))->select('user_id')->get();
        $total_users = DB::table('users')->select('id')->get();
        $absents = [];
        $users = [];
        foreach($current_users as $current_user){$absents[] = $current_user->user_id;}
        foreach($total_users as $total_user){$users[] = $total_user->id;}
        $absent_users = array_diff($users, $absents); //returns the yesterday absent users array

        foreach($absent_users as $absent_user){
            $attendence = new Attendence;
            $attendence->user_id = $absent_user;
            $attendence->present = false;
            $attendence->date = date('Y-m-d', strtotime('-1 day'));
            $attendence->late = false;
            $attendence->save();
        }
    }
}
