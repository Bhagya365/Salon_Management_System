<?php


namespace App\Http\Controllers;


use App\Appointment;
use App\Client;
use App\User;
use App\Sale;
use App\SaleItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboardIndex()
    {


        if(Auth::user()->user_role_iduser_role==4){

            $userId = User::find(Auth::user()->idmaster_user);

            //Total
            $canceledApp = Appointment::where('status', 2)->where('client_id', $userId->idmaster_user)->count('idappointment');
            $pendingApp = Appointment::where('status', 0)->where('client_id', $userId->idmaster_user)->count('idappointment');
            $completedApp = Appointment::where('status', 1)->where('client_id', $userId->idmaster_user)->count('idappointment');


            $clientSaleIds = Sale::where('client_idclient', $userId->idmaster_user)->pluck('idsale');

            $canceledPur = SaleItem::where('status', 2)
                ->whereIn('sale_idsale', $clientSaleIds)
                ->count('idsale_item');

            $pendingPur = SaleItem::where('status', 0)
                ->whereIn('sale_idsale', $clientSaleIds)
                ->count('idsale_item');

            $completedPur = SaleItem::where('status', 1)
                ->whereIn('sale_idsale', $clientSaleIds)
                ->count('idsale_item');
            // === END MODIFIED ===

        }



        else{

            //Total
            $canceledApp = Appointment::where('status', 2)->count('idappointment');
            $pendingApp = Appointment::where('status', 0)->count('idappointment');
            $completedApp = Appointment::where('status', 1)->count('idappointment');

            $canceledPur = SaleItem::where('status', 2)->count('idsale_item');
            $pendingPur = SaleItem::where('status', 0)->count('idsale_item');
            $completedPur = SaleItem::where('status', 1)->count('idsale_item');


        }


//New Clients Daily
        $totCustomers = Client::whereDate('created_at', Carbon::today())->get()->count('idclient');




        return view('index', [
            'title' => 'Dashboard', 
            'pendingApp' => $pendingApp,  
            'canceledApp' => $canceledApp, 
            'completedApp' => $completedApp, 
            'totCustomers' => $totCustomers,
            'canceledPur' => $canceledPur,  
            'pendingPur' => $pendingPur, 
            'completedPur' => $completedPur
            ]);


    }


}