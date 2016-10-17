<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Role;
use App\User;
use App\AttendenceSettings;

use Auth;
use DB;
use App\Attendence;

class AdminController extends Controller
{
    //
    public function getAttendenceSettings()
    {   
        //dd(Attendence::where("user_id", 1)->get());
        //dd(Role::where('name', 'User')->first());
        $attendence_settings = AttendenceSettings::find(1);

        return view('admin.attendence-settings', compact('attendence_settings'));
    }

    public function postAttendenceSettings(Request $request)
    {
        $this->validate($request, [
            'working_hour' => 'required|date_format: H:i:s', 
            'arrival_time' => 'required|date_format: H:i:s', 
            'cron_time' => 'required|date_format: H:i', 
            'check_out' => 'required|date_format: H:i:s'
        ]);

        $attendence_settings = AttendenceSettings::find(1);
        $attendence_settings->total_work_hour = $request->working_hour;
        $attendence_settings->arrival_time = $request->arrival_time;
        $attendence_settings->cron_time = $request->cron_time;
        $attendence_settings->check_out_fixed = $request->check_out;
        $attendence_settings->save();

        return back()->with(['success' => 'Successfully your settings are saved']);
    }

    public function getAssignRoles()
    {   
        $users = User::all();
        return view('admin.acl-settings', compact('users'));
    }

    public function postAssignRoles(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->roles()->detach();

        if($request->role_user) {
            $user->roles()->attach(Role::where('name', 'User')->first());
        }

        if($request->role_admin) {
            $user->roles()->attach(Role::where('name', 'Admin')->first());
        }

        return redirect()->back();
    }
}
