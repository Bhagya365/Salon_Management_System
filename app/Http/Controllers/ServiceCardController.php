<?php

namespace App\Http\Controllers;

use App\ServiceCard;
use App\Appointment;
use App\Client;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceCardController extends Controller
{
    public function index(){
        // CHANGED: Load clients, categories, and recent service cards for cart-style makeServiceCard page
        $clients = Client::all();
        $categories = Category::all();
        $cards = ServiceCard::with(['client', 'appointments'])->orderBy('idservice_card', 'desc')->get();

        return view('service_card.makeServiceCard', [
            'title' => 'Make Service Card',
            'clients' => $clients,
            'categories' => $categories,
            'cards' => $cards,
        ]);
    }


    public function getFilteredAppointments(Request $request){
        
        $query = Appointment::whereNull('service_card_idservice_card')
            ->where('status', '!=', 2)
            ->with(['Category', 'Client']);

        if($request->filled('client_id')){

            $query->where('client_id', $request->client_id);
        }
        if($request->filled('category_id')){

            $query->where('category_idcategory', $request->category_id);
        }
        if($request->filled('appointment_date')){

            $query->whereDate('date', $request->appointment_date);
        }

        return response()->json($query->get());
    }


    public function saveServiceCard(Request $request){

        $loginUser = Auth::user();

        if(!in_array($loginUser->user_role_iduser_role, [1, 3])){

            return response()->json(['errors' => ['permission' => ['Only Front Office or Admin can generate a Service Card.']]]);
        }

        $validator = \Validator::make($request->all(), [
            'client_id'        => 'required|integer',
            'appointment_ids'  => 'required|array|min:1',
        ]);

        if($validator->fails()){

            return response()->json(['errors' => $validator->errors()]);
        }

        $appointments = Appointment::whereIn('idappointment', $request->appointment_ids)->get();

        $mismatchedClient = $appointments->first(function($apt) use ($request){

            return $apt->client_id != $request->client_id;

        });

        if($mismatchedClient){

            return response()->json(['errors' => ['appointment_ids' => ['All selected appointments must belong to the selected client.']]]);
        }

        $dates = $appointments->pluck('date')->map(function($d){

            return Carbon::parse($d)->format('Y-m-d');

        })->unique();

        $today = Carbon::today();

  
        if($dates->first(function($d) use ($today){ return Carbon::parse($d)->gt($today); })){

            return response()->json(['errors' => ['appointment_ids' => ['Only appointments today or in the past can be added to a Service Card.']]]);
        }

      
        $card = ServiceCard::create([
            'client_id' => $request->client_id,
            'status'    => ServiceCard::STATUS_PENDING, // 0 for pending
        ]);


        Appointment::whereIn('idappointment', $request->appointment_ids)
            ->update(['service_card_idservice_card' => $card->idservice_card]);

        return response()->json(['success' => 'Service Card generated successfully.']);
    }
}
