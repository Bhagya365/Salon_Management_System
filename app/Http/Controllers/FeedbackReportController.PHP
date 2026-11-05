<?php


namespace App\Http\Controllers;


use App\Feedback;
use App\Appointment;
use App\Client;
use App\User;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackReportController extends Controller

{

    public function feedbackReportIndex(Request $request){


        $feedbacks=Feedback::query();

        $clientName=$request['clientName'];
        $stylistName = $request['stylistName'];
        $rate= $request['rate'];
        $fromDate= $request['startDate'];
        $endDate= $request['endDate'];

        $titleParts = [];

        //Filter by Client Name
        if ($clientName) {

            $appointmentIds = Appointment::where('client_id', $clientName)->pluck('idappointment');
            $feedbacks = $feedbacks->whereIn('appointment_idappointment', $appointmentIds);

            $clientObj = Client::find($clientName);
            if ($clientObj) {
                $titleParts[] = "Client: {$clientObj->first_name} {$clientObj->last_name}";
            }
        }
        

        //Filter by stylist Name
        if ($stylistName) {

            $appointmentIds = Appointment::where('master_user_idmaster_user', $stylistName)->pluck('idappointment');
            $feedbacks = $feedbacks->whereIn('appointment_idappointment', $appointmentIds);

            $stylistObj = User::find($stylistName);
            if ($stylistObj) {
                $titleParts[] = "User: {$stylistObj->first_name} {$stylistObj->last_name}";
            }
        }
        


        // Filter by Rate
        if($rate){
            $validRates = ['1', '2', '3', '4', '5'];

            if(in_array($rate, $validRates)){
                $feedbacks = $feedbacks->where('rating', $rate);
                $titleParts[] = "Rate: $rate";
            }
        }

        // Filter by date range
        if($fromDate){
            $feedbacks = $feedbacks->whereDate('created_at','>=',date('Y-m-d',strtotime($fromDate)));
            $titleParts[] = "From: $fromDate";
        }

        if($endDate){
            $feedbacks = $feedbacks->whereDate('created_at','<=',date('Y-m-d',strtotime($endDate)));
            $titleParts[] = "To: $endDate";
        }

    



        // get  data from db to dropdown menu
        $clients = User::where('user_role_iduser_role',4)->get();
        $stylists = User::where('user_role_iduser_role',2)->get();


        $feedbacks = $feedbacks->get();




        if(count($titleParts) > 0){
            Report::create([
                'report_title' => 'Feedback Report - ' . implode(', ', $titleParts),
                'report_type'  => 'Feedback',
                'date'  => date('Y-m-d'),
                'master_user_idmaster_user' => Auth::id(),
            ]);
        }

        return view('reports.feedbackReport',[
            'title' => 'Feed Back Report - Salon Management System' . "\n" . implode(', ', $titleParts),
            'feedbacks' => $feedbacks,
            'clients' => $clients,
            'stylists' => $stylists,

            ]);
    }


}