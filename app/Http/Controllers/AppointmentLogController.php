<?php


namespace App\Http\Controllers;

use App\Appointment;
use App\Payment;
use App\User;
use App\Category;
use App\TimeSlot;
use App\Feedback;
use App\Attendance;
use App\ServiceCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentLogController extends Controller
{

    public function appointmentLog(){


        // cheking attendance start

        $loginUser = Auth::user();
        $today = date('Y-m-d');

        // Check if user is marked absent today
        $attendance = Attendance::where('master_user_idmaster_user', $loginUser->idmaster_user)
            ->where('date', $today)
            ->first();

        $readOnly = false;

        // Block for absent (status 0 or no record)
        if ($loginUser->user_role_iduser_role == 2  || $loginUser->user_role_iduser_role == 3) {
            if (!$attendance || $attendance->status == 0) {
                $readOnly = true;
            }
        }

        // cheking attendance end



        $categories=Category::where('status',1)->get();

        $loginUser=Auth::user();

        $appointments=[];

        if($loginUser->user_role_iduser_role==1 || $loginUser->user_role_iduser_role==3){
            $appointments=Appointment::all();
        }

        else if($loginUser->user_role_iduser_role==2){
            $appointments=Appointment::where('master_user_idmaster_user',Auth::user()->idmaster_user)->get();
        }

        else if($loginUser->user_role_iduser_role==4){
            $appointments=Appointment::where('client_id',Auth::user()->idmaster_user)->get();
        }




        $user=User::all();
        $userClients=User::where('user_role_iduser_role',2)->get();
        $timeSlots=TimeSlot::all();

        return view('appointment.appointmentLog',['title'=>'Appointment Log',
            'categories'=>$categories,
            'appointments'=>$appointments,
            'user'=>$user,
            'userClients'=>$userClients,
            'timeSlots'=>$timeSlots,
            ],compact('readOnly'));

    }

    public function savePayment(request $request){
        $changeStatus=Appointment::find($request['appointmentID']);
        $changeStatus->status=1;
        $changeStatus->payment_type=$request['payment_type'];   // cash or card
        $changeStatus->save();

        $savepayment=new Payment();            // completed appointments
        $savepayment->appointment_idappointment=$request['appointmentID'];
        $savepayment->amount=$changeStatus->amount;
        $savepayment->payment_type=$request['payment_type'];   // cash or card
        $savepayment->save();

        // CHANGED: When payment button is pressed in appointment log, convert associated ServiceCard table status to 1 (Completed)
        if ($changeStatus && $changeStatus->service_card_idservice_card) {
            $serviceCard = ServiceCard::find($changeStatus->service_card_idservice_card);
            if ($serviceCard) {
                $serviceCard->status = ServiceCard::STATUS_COMPLETED; // status equals to 1 - completed
                $serviceCard->save();
            }
        }

        return response()->json(['success'=>'payment saved']);

    }


    public function cancelAppointment(request $request)
    {
        $cancelAppointment=Appointment::find($request['aptId']);
        $cancelAppointment->status=2;
        $cancelAppointment->payment_type='CANCELED';
        $cancelAppointment->save();

        return response()->json(['success'=>'APPOINTMENT CANCELED']);
    }

    public function saveFeedback(request $request){

        $savefeedback=new Feedback();          
        $savefeedback->appointment_idappointment=$request['appointmentID'];
        $savefeedback->rating=$request['rate'];  
        $savefeedback->comment=$request['comment'];  
        $savefeedback->save();

        return response()->json(['success'=>'Feedback saved']);

    }

}