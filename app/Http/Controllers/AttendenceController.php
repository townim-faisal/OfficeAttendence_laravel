<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Attendence;
use App\AttendenceSettings;
use Auth;
Use DB;

use Carbon\Carbon;

class AttendenceController extends Controller
{
    //
    public $time;
    public $date;
    public $current_time;
    public $attendence_settings;

    public function __construct()
    {
        $this->time = date("h:i:sa"); //returns the current time in am/pm
        $this->date = date("d"); //returns the date of current month
        $this->current_time = Carbon::now()->toDateTimeString(); //return the current time in date-time string
        $this->attendence_settings = AttendenceSettings::find(1);
    }

    public function index(Request $request)
    {
    	$user = Auth::user();
        $attendences = Attendence::where('user_id', $user->id)->get();
        
        $calender = $this->calender($request);
        
        $curr_month = $calender[0]; $maxday = $calender[1]; $prev_month = $calender[2]; $prev_year = $calender[3]; $next_month = $calender[4]; $next_year = $calender[5]; $month = $calender[6];    	

        return view('attendence', compact('user', 'attendences', 'curr_month', 'maxday', 'prev_month', 'prev_year', 'next_month', 'next_year', 'month'));
    }

    public function store(Request $request)
    {	
        $check_in = DB::table('attendences')
                        ->where('user_id', $request->user_id)
                        ->whereNull('check_out')
                        ->latest()
                        ->value('check_in');

        $attendence = $this->storeAttendence($request, $check_in);

        return response()->json(['success' => $attendence['success'], 
                                'time' => $attendence['time'],
                                'date' => $attendence['date'],
                                'late' => $attendence['late']
                                ]);
        
    }

    public function update(Request $request)
    {	
        $attendence = Attendence::latest()
                        ->where('user_id', $request->user_id)
                        ->first();
        $check_out = $attendence->check_out;

        $working_hour = gmdate('H:i:s', (strtotime($this->current_time)-strtotime($attendence->check_in)));
        $short = ($working_hour < $this->attendence_settings->total_work_hour) ? 'Today your working hour is short' : ''; 

        if($check_out == null) :
            $attendence->check_out = $this->current_time;
            $attendence->working_hour = $working_hour;
            $attendence->save();
        	return response()->json(['success' => 'Successfully Check Out', 
                                    'time' => $this->time,
                                    'date' => $this->date,
                                    'working_time' => $attendence->working_hour,
                                    'short' => $short
                                    ]);
        else:
            return response()->json(['success' => 'You have already checked out']);
        endif;       
    }

    //calender
    public function calender($request)
    {
        if(!isset($request->month)) $request->month = date("m"); 
        if(!isset($request->year)) $request->year = date("Y");

        $curr_month = $request->month; //from GET request
        $curr_year = $request->year;
        $timestamp = mktime(0,0,0,$curr_month,1,$curr_year);
        $maxday = date("t",$timestamp);
        $month = date("M, Y",$timestamp);

        $prev_year = $curr_year;
        $next_year = $curr_year;
        $prev_month = $curr_month-1;
        $next_month = $curr_month+1;
         
        if($prev_month == 0 ) {
            $prev_month = 12;
            $prev_year = $curr_year - 1;
        }
        if($next_month == 13 ) {
            $next_month = 1;
            $next_year = $curr_year + 1;
        }

        return [$curr_month, $maxday, $prev_month, $prev_year, $next_month, $next_year, $month];
    }


    //store attendence by checking parameters
    public function storeAttendence($request, $check_in)
    {   
        $check_date = Attendence::latest()->where('user_id', $request->user_id)->where('date', date("Y-m-d"))->count();

        $late = (date('H:i:s') > $this->attendence_settings->arrival_time) ? true : false;

        $late_status = ($late == true) ? 'You are late!' : '';

        if($check_in == null && $check_date == 0) :
            $attendence = new Attendence;
            $attendence->user_id = $request->user_id;
            $attendence->check_in = $this->current_time;
            $attendence->date = date("Y-m-d");
            $attendence->present = true;
            $attendence->late = $late;
            $attendence->save();
            
            return ['success' => 'Successfully Check In', 'late' => $late_status, 'time' => $this->time,
                    'date' => $this->date,];
        else:
            return ['success' => 'You have already checked in', 'late' => $late_status, 'time' => '',
                    'date' => ''];
        endif;
    }

}
