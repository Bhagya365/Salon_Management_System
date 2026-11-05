<?php


namespace App\Http\Controllers;


use App\User;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){


        $today = date('Y-m-d');
        $loginUser = Auth::user();


        if($loginUser->user_role_iduser_role == 1){
            
            // Admin -> see stylists + front office
            $staff = User::whereIn('user_role_iduser_role', [2,3])->where('status', 1);
        }
        

        else if($loginUser->user_role_iduser_role == 3){

             // Front Office -> sees stylists only
            $staff = User::where('user_role_iduser_role', 2)->where('status', 1);
        }
        
        else {
            abort(403, 'Unauthorized access.');

        }

        $staff = $staff->with(['Attendance' => function($q) use ($today){$q->where('date', $today); }])->get();

        return view('attendance.attendance', [
            'title' => 'Staff Attendance',
            'attendances' => $staff,
            // 'frontOfficeCheckedIn' => $frontOfficeCheckedIn,
            ]);

    }



    public function markAttendance(Request $request){

        $targetUserId = $request['id']; 
        $loginUser = Auth::user();
        $today = date('Y-m-d');

        $targetUser = User::find($targetUserId);

        if(!$targetUser){
            return response()->json(['error' => 'User not found.']);
        }

        if($targetUserId == $loginUser->idmaster_user){
            return response()->json(['error' => 'You cannot mark your own attendance.']);
        }


        if($loginUser->user_role_iduser_role == 1){

            if(!in_array($targetUser->user_role_iduser_role, [2,3])){

                return response()->json(['error' => 'Admin can mark stylist or front office attendance.']);
            }

        } else if($loginUser->user_role_iduser_role == 3){

            if($targetUser->user_role_iduser_role != 2){

                return response()->json(['error' => 'Front office can only mark stylist attendance.']);
            }

        } else {

            return response()->json(['error' => 'You are not authorized to mark attendance.']);
        }


        $attendance = Attendance::firstOrNew([
            'master_user_idmaster_user' => $targetUserId,
            'date' => $today,
        ]);

        // Ensure new rows start at 0 (Out/Absent)
        if (!$attendance->exists) {
            $attendance->status = 0;
        }

        if($attendance->status == 1){
            $attendance->status = 0;

        } else {

            $attendance->status = 1;
            $attendance->check_in = date('Y-m-d H:i:s');
        }

        $attendance->marked_by = $loginUser->idmaster_user; 
        
        $attendance->save();

        return response()->json(['success' => true, 'status' => $attendance->status]);
    }

}