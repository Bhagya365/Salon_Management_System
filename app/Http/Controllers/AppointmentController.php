<?php


namespace App\Http\Controllers;


use App\Appointment;
use App\Payment;
use App\User;
use App\Client;
use App\Category;
use App\TimeSlot;
use App\Feedback;
use App\Attendance;
use App\ServiceCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index(){


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



        // get  data from db to dropdown menu
        $categories=Category::where('status',1)->get();
        $servicecategories=Category::select('category_name')->distinct()->orderBy('category_name')->get();


        //Only showing appointments of logged in client and showing all appointments for other roles in makeAppointment.
        if(Auth::user()->user_role_iduser_role==2){
            $appointments=Appointment::where('master_user_idmaster_user',Auth::user()->idmaster_user)->get();
        }
        else if(Auth::user()->user_role_iduser_role==4){
            $appointments=Appointment::where('client_id',Auth::user()->idmaster_user)->get();
        }

        else{
            $appointments=Appointment::all();
        }



        $user=User::all();
        $userLogged=Auth::user();
        $userStylists=User::where('user_role_iduser_role',2)->get(); 
        $userClients=User::where('user_role_iduser_role',4)->where('status', 1)->get();
        $timeSlots = TimeSlot::where('status', 1)->orderBy('time_slot', 'asc')->get();


        $maxDays = Carbon::now()->addDays(13); 


        return view('appointment.makeAppointment',['title'=>'Appointment',
            
            'servicecategories'=>$servicecategories,
            'categories'=>$categories,
            'appointments'=>$appointments,
            'user'=>$user,
            'userClients'=>$userClients,
            'userStylists'=>$userStylists,
            'timeSlots'=>$timeSlots,

            'userLogged'=>$userLogged,
            'maxDays'=>$maxDays,


            ],compact('readOnly'));
    }


  
    public function cancelAppointment(request $request)
        {
            $cancelAppointment=Appointment::find($request['aptId']);
            $cancelAppointment->status=2;
            $cancelAppointment->payment_type='CANCELED';
            $cancelAppointment->save();

            return response()->json(['success'=>'APPOINTMENT CANCELED']);
        }

    public function showAmount(Request $request){

        $categoryId = $request['categoryId'];

        return Category::find($categoryId);   
    }


    public function saveAppointment(Request $request){

        $client= $request['client'];
        $category = $request['category'];
        $stylist = $request['stylist'];
        $date = $request['date'];
        $timeSlot = $request['timeSlot'];
        

        //Validation Start
        $validator = \Validator::make($request->all(), [


            'category'  =>   'required',
            'client'  =>   'required',
            'stylist'  =>   'required',
            'date'  =>   'required',
            'timeSlot'  =>   'required',


        ], [
            'category.required' =>  'Service should be Selected!',

            'client.required' =>  'Client should be Selected!',

            'stylist.required' =>  'Stylist should be Selected!',

            'date.required' =>  'Date should be Selected!',

            'timeSlot.required' =>  'Time Slot should be Selected!'


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

//Validation End


        $amount=Category::find($category)->amount;


        $save=new Appointment();   // default pending appointments- not goes to payment table

        $save->date=$date;
        $save->status=0;
        $save->amount=$amount;
        $save->payment_type='PENDING';
        $save->master_user_idmaster_user=$stylist;         // master user saved stylist id
        $save->time_slot_idtime_slot=$timeSlot;
        $save->client_id=$client;
        $save->category_idcategory=$category;


        $save->save();

      return response()->json(['success'=>'Appointment Saved']);

    }



    public function getTimeSlot(Request $request){


        $stylistId=$request['stylist'];
        $date=$request['date'];

        $timeSlotIds=Appointment::whereIn('status',[0,1])->where('master_user_idmaster_user',$stylistId)->where('date',$date)->pluck('time_slot_idtime_slot');

        $availableTimeSlots=TimeSlot::whereNotIn('idtime_slot',$timeSlotIds)->get();



        $table=''; //Declare a variable
        $table.="<select  class='form-control' name='timeSlot' id='timeSlot' required>"; //append to that variable
        
        foreach ($availableTimeSlots as $availableTimeSlot){

            $table.="<option value='$availableTimeSlot->idtime_slot'>$availableTimeSlot->time_slot</option>";
        }
        
        $table.="</select>";


        return $table; 
    
    }




    //method to filter services by category name
    public function getServicesByCategory(Request $request){

    $categoryName = $request['category_name'];

    $services = Category::where('category_name', $categoryName)->where('status', 1) ->get();

    return response()->json($services);
    
    }


     //method to filter stylists by date
    public function getStylistsForDate(Request $request){

        $date = $request['date'];
        $today = Carbon::now()->format('Y-m-d');

        if($date == $today){

            // present in today's attendance
            $presentStylistIds = Attendance::where('date', $date)->where('status', 1)->pluck('master_user_idmaster_user');

            $stylists = User::where('user_role_iduser_role', 2)->where('status', 1)->whereIn('idmaster_user', $presentStylistIds)->get();

        } 
        else {

            // Future date - attendance not recorded yet, show all stylists
            $stylists = User::where('user_role_iduser_role', 2) ->where('status', 1)->get();
        }

        return response()->json($stylists);
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

    public function saveFeedback(request $request){

        $savefeedback=new Feedback();          
        $savefeedback->appointment_idappointment=$request['appointmentID'];
        $savefeedback->rating=$request['rate'];  
        $savefeedback->comment=$request['comment'];  
        $savefeedback->save();

        return response()->json(['success'=>'Feedback saved']);

    }



}