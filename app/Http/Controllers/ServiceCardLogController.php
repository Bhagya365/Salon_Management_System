<?php


namespace App\Http\Controllers;

use App\ServiceCard;
use App\Appointment;
use App\Client;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ServiceCardLogController extends Controller

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


        $cards = $this->scopedCards()->with(['client', 'appointments'])->get();

        $pendingCount    = $this->scopedCards()->where('status', ServiceCard::STATUS_PENDING)->count();
        $inProgressCount = $this->scopedCards()->where('status', ServiceCard::STATUS_IN_PROGRESS)->count();
        $completedCount  = $this->scopedCards()->where('status', ServiceCard::STATUS_COMPLETED)->count();



        $clients = Client::all();

        return view('service_card.serviceCardLog', [
            'title' => 'Service Card Log',
            'cards' => $cards,                       
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'clients' => $clients,
        ],compact('readOnly'));
    }

    private function scopedCards(){
        $loginUser = Auth::user();

        if($loginUser->user_role_iduser_role == 1 || $loginUser->user_role_iduser_role == 3){
            return ServiceCard::query();
        }
        else if($loginUser->user_role_iduser_role == 2){
            return ServiceCard::whereHas('appointments', function($q) use ($loginUser){
                $q->where('master_user_idmaster_user', $loginUser->idmaster_user);
            });
        }
        else{
            abort(403, 'You are not authorized to view Service Cards.');
        }
    }


    public function getServiceCardData($id){
        
        $card = $this->scopedCards()->with(['appointments.Category', 'client'])->findOrFail($id);

        
        $availableAppointments = Appointment::where('client_id', $card->client_id)
            ->where(function($q) use ($card){
                $q->whereNull('service_card_idservice_card')->orWhere('service_card_idservice_card', $card->idservice_card);
            })->with('Category')->get();

        return response()->json([
            'card'         => $card,
            'appointments' => $availableAppointments,
            'selectedIds'  => $card->appointments->pluck('idappointment'),
        ]);
    }


    public function show($id){
        $card = $this->scopedCards()->with(['client', 'appointments.Category'])->findOrFail($id);
        return view('servicecardshow', ['title' => 'Service Card Detail', 'card' => $card]);
    }


   
    public function setInProgress($id){
        $loginUser = Auth::user();
        
        if(!in_array($loginUser->user_role_iduser_role, [1, 2, 3])){
            return response()->json(['errors' => ['permission' => ['You are not authorized to update a Service Card.']]]);
        }

        $card = ServiceCard::findOrFail($id);

        
        if($card->status != ServiceCard::STATUS_PENDING && $card->status != 0){
            return response()->json(['errors' => ['status' => ['Only a Pending Service Card can be moved to In Progress.']]]);
        }

        $card->status = ServiceCard::STATUS_IN_PROGRESS;
        $card->save();

        return response()->json(['success' => 'Service Card marked as In Progress.']);
    }

}