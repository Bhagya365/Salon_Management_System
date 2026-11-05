<?php


namespace App\Http\Controllers;


use App\Appointment;
use App\Client;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppointmentReportController extends Controller

{

    public function appointmentReportIndex(Request $request){


        $appointments=Appointment::query();


        $fromDate=$request['startDate'];
        $endDate=$request['endDate'];
        $client_name=$request['clientName'];
        $statusId=$request['status'];


        // report_title from whichever filters were used
        $titleParts = [];

        // Filter by range
        if($fromDate){

            $appointments=$appointments->whereDate('created_at','>=',date('Y-m-d',strtotime($fromDate)));
            $titleParts[] = " From: $fromDate";
        }


        if($endDate){
            $appointments=$appointments->whereDate('created_at','<=',date('Y-m-d',strtotime($endDate)));
            $titleParts[] = " To: $endDate";
        }

        // Filter by Customer Name
        if($client_name){

            $appointments = $appointments->where('client_id', $client_name);
            // real name to make the log human-readable
            $clientObj = Client::find($client_name);
            if($clientObj){
                $titleParts[] = "Client: {$clientObj->first_name} {$clientObj->last_name}";
            }
        }



        // Filter by status
        if($statusId){
            $statusMap = [                          //  using a mapping array
                'Pending'   => 0,
                'Completed' => 1,
                'Cancelled'  => 2,
            ];

            if(isset($statusMap[$statusId])){
                $appointments = $appointments->where('status', $statusMap[$statusId]);
                $titleParts[] = "Status: $statusId";
            }
        }
        

        // Filter by appointmnet id
        // if($appId){
        //     $numericAppId = preg_replace('/[^0-9]/', '', $appId);  

        //     if($numericAppId !== ''){
        //         $appointments = $appointments->where('idappointment', 'like', '%' . $numericAppId . '%');
        //         $titleParts[] = "ApptID: $numericAppId";
        //     }
        // }




        // Always load ALL clients for the dropdown, on every page load/search
        $clients = Client::all();

        $appointments=$appointments->get();

        // not on the initial blank page load (prevents flooding the report table).
        if(count($titleParts) > 0){
            Report::create([
                'report_title'   => 'Appointment Report - ' . implode(', ', $titleParts),
                'report_type'    => 'Appointment',
                'date'           => date('Y-m-d'),
                'master_user_idmaster_user' => Auth::id(),
            ]);
        }

        return view('reports.appointmentReport',[
            'title' => 'Appointment Report - Salon Management System' . "\n" . implode(', ', $titleParts),
            'appointments'=>$appointments,
            'clients' => $clients
            ]);

        }




    }
