<?php

namespace App\Http\Middleware;

use App\Attendance;
use Closure;
use Illuminate\Support\Facades\Auth;

class BlockAbsentStaff
{
    public function handle($request, Closure $next)
    {
        $loginUser = Auth::user();

        // Admin is never blocked
        if(!$loginUser || $loginUser->user_role_iduser_role == 1){
            return $next($request);
        }

        $today = date('Y-m-d');

        $isMarkedAbsent = Attendance::where('master_user_idmaster_user', $loginUser->idmaster_user)
            ->where('date', $today)
            ->first();

        // check atttendance only front office and stylists
        if ($loginUser->user_role_iduser_role == 2  || $loginUser->user_role_iduser_role == 3) {

            if(!$isMarkedAbsent || $isMarkedAbsent->status == 0){
                return redirect()->route('/')
                    ->with('error', 'You are marked absent today and cannot access this page.');
            }
        }      

        return $next($request);

    }
}