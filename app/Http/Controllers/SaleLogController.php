<?php

namespace App\Http\Controllers;

use App\Sale;
use App\SaleItem;
use App\Product;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleLogController extends Controller
{
    public function saleLog()
    {


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

    
        $loginUser = Auth::user();
        $sales = [];

        // mirrors the role-based scoping in AppointmentLogController
        if ($loginUser->user_role_iduser_role == 1 || $loginUser->user_role_iduser_role == 3) {

            $sales = Sale::with(['items', 'Client'])->orderBy('created_at', 'desc')->get();

        } elseif ($loginUser->user_role_iduser_role == 2) {

            $sales = Sale::with(['items', 'Client'])
                ->where('master_user_idmaster_user', Auth::user()->idmaster_user)
                ->orderBy('created_at', 'desc')->get();

        } elseif ($loginUser->user_role_iduser_role == 4) {

            $sales = Sale::with(['items', 'Client'])
                ->where('client_idclient', Auth::user()->idmaster_user)
                ->orderBy('created_at', 'desc')->get();
        }

        return view('sales.saleLog', [
            'title' => 'Sale Log',
            'sales' => $sales,
        ],compact('readOnly'));
    }

    public function savePayment(Request $request)
    {
        // server-side role check — the buttons are hidden in the view
        // for other roles, but that alone doesn't stop a direct POST
        $role = Auth::user()->user_role_iduser_role;
        if ($role != 1 && $role != 3) {
            return response()->json(['error' => 'Not authorized'], 403);
        }

        $sale = Sale::find($request['saleID']);
        if (!$sale) {
            return response()->json(['error' => 'Sale not found']);
        }

        $sale->status = 1; // completed
        $sale->payment_type = $request['payment_type']; // CASH or CARD
        $sale->save();

        // keep sale_item rows in sync with the sale header
        SaleItem::where('sale_idsale', $sale->idsale)->update(['status' => 1]);

        return response()->json(['success' => 'payment saved']);
    }

    public function cancelPurchase(Request $request)
    {
        $role = Auth::user()->user_role_iduser_role;
        if ($role != 1 && $role != 3 && $role != 4) {
            return response()->json(['error' => 'Not authorized'], 403);
        }

        $sale = Sale::find($request['saleId']);
        if (!$sale) {
            return response()->json(['error' => 'Sale not found']);
        }

        $sale->status = 2; // canceled
        $sale->payment_type = 'CANCELED';
        $sale->save();

        $items = SaleItem::where('sale_idsale', $sale->idsale)->get();
        foreach ($items as $item) {
            $product = Product::find($item->product_idproduct);
            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();
            }
            $item->status = 2;
            $item->save();
        }

        return response()->json(['success' => 'PURCHASE CANCELED']);
    }
}