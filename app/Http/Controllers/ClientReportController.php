<?php


namespace App\Http\Controllers;


use App\Client;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientReportController extends Controller

{

    public function clientReportIndex(Request $request){


        $clients=Client::query();

        $fromDate=$request['startDate'];
        $endDate=$request['endDate'];
        // $clientId=$request['clientId'];
        // $clientName=$request['clientName'];
        // $contactNo=$request['contactNo'];

        // report_title from whichever filters were used
        $titleParts = [];

        if($fromDate){

            $clients=$clients->whereDate('created_at','>=',date('Y-m-d',strtotime($fromDate)));
            $titleParts[] = " From: $fromDate";
        }


        if($endDate){
            $clients=$clients->whereDate('created_at','<=',date('Y-m-d',strtotime($endDate)));
            $titleParts[] = " To: $endDate";
        }

        // Filter by client id
        // if($clientId){
        //     $numericclientId = preg_replace('/[^0-9]/', '', $clientId);  //  remove everything that is not a digit (0-9)

        //     if($numericclientId !== ''){
        //         $clients = $clients->where('idclient', 'like', '%' . $numericclientId . '%');
        //         $titleParts[] = "ClientID: $numericclientId";
        //     }
        // }

        // Filter by Customer Name
        // if($clientName){
        //     $clients = $clients->where('idclient', $clientName);

        //     $clientObj = Client::find($clientName);
        //     if($clientObj){
        //         $titleParts[] = "Client: {$clientObj->first_name} {$clientObj->last_name}";
        //     }
        // }

        // Filter by contact No
        // if($contactNo){
        //     $clients = $clients->where('contact_number', $contactNo);
        //     $titleParts[] = "ContactNo: $contactNo";
        // }


        $clients=$clients->get();

        if(count($titleParts) > 0){
            Report::create([
                'report_title'   => 'Client Report - ' . implode(', ', $titleParts),
                'report_type'    => 'Client',
                'date'           => date('Y-m-d'),
                'master_user_idmaster_user' => Auth::id(),
            ]);
        }

        return view('reports.clientReport',[
            'title' => 'Client Report - Salon Management System' . "\n" . implode(', ', $titleParts),
            'clients' => $clients
            ]);


    }
}
