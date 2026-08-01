<?php


namespace App\Observers;


use App\User;
use App\Attendance;

class UserObserver
{
    public function updated(User $user)
    {
        // If status changed from active (1) to inactive (0)
        if ($user->isDirty('status') && $user->status == 0) {
            // Update all their attendance records to status 0
            Attendance::where('master_user_idmaster_user', $user->idmaster_user)
                ->update(['status' => 0]);
        }
    }
}