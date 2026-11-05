<?php


namespace App\Http\Controllers;

use App\Feedback;
use App\User;
use App\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class FeedbackController extends Controller
{

    public function index(){


        $loginUser = Auth::user();

        if($loginUser->user_role_iduser_role == 1 || $loginUser->user_role_iduser_role == 3){
            $feedbacks = Feedback::get();
        }


        else if($loginUser->user_role_iduser_role == 2){

            $appointmentIds = Appointment::where('master_user_idmaster_user', Auth::user()->idmaster_user)->pluck('idappointment');
            $feedbacks = Feedback::whereIn('appointment_idappointment', $appointmentIds)->get();
        }

        else{
            //CLIENT
            $appointmentIds = Appointment::where('client_id', Auth::user()->idmaster_user)->pluck('idappointment');
            $feedbacks = Feedback::whereIn('appointment_idappointment', $appointmentIds)->get();
        }
        
        
        return view('feed_back.feedBack',['title'=>'Feed Back', 'feedbacks'=>$feedbacks]);



    }



}