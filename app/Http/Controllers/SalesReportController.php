<?php


namespace App\Http\Controllers;


use App\Sale;
use App\Client;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller


{
    public function salesReportIndex(Request $request)
    {

        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $client_name=$request['clientName'];
        $paytype=$request['paytype'];
        // $appId=$request['appointmentId'];


        $query = Sale::query();

        // report_title from whichever filters were used
        $titleParts = [];

        if (!empty($startDate) && !empty($endDate)) {

            $startDate = date('Y-m-d', strtotime($request['startDate']));
            $endDate = date('Y-m-d', strtotime($request['endDate']));

            $query = $query->whereBetween('updated_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]); //filter from date
        }


        // Filter by Customer Name
        if($client_name){
            $query = $query->where('client_idclient', $client_name);

            $clientObj = Client::find($client_name);
            if($clientObj){
                $titleParts[] = "Client: {$clientObj->first_name} {$clientObj->last_name}";
            }
        }

        // Filter by Payment Type
        if($paytype){
            $validPayTypes = ['CASH', 'CARD'];

            if(in_array($paytype, $validPayTypes)){
                $query = $query->where('payment_type', $paytype);
                $titleParts[] = "Payment Type: $paytype";
            }
        }

        
        // Filter by appointmnet id
        // if($appId){
        //     $numericAppId = preg_replace('/[^0-9]/', '', $appId); 

        //     if($numericAppId !== ''){
        //         $query = $query->where('idappointment', 'like', '%' . $numericAppId . '%');
        //         $titleParts[] = "ApptID: $numericAppId";
        //     }
        // }


        $sales = $query->where('status', 1)->get();


        $total = $sales->sum('total_amount'); //Sum of Amounts
        $clients = Client::all();

        // not on the initial blank page load (prevents flooding the report table).
        if(count($titleParts) > 0){
            Report::create([
                'report_title'   => 'Income Report - ' . implode(', ', $titleParts),
                'report_type'    => 'Income',
                'date'           => date('Y-m-d'),
                'master_user_idmaster_user' => Auth::id(),
            ]);
        }


        return view('reports.salesReport',[
            'title' => 'Income Report - Salon Management System' . "\n" . implode(', ', $titleParts),
            'sales'=>$sales,
            'clients' => $clients,
            'total'=> $total
            ]);

        }


}
