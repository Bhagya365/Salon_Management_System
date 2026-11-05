<?php


namespace App\Http\Controllers;


use App\Sale;
use App\SaleItem;
use App\Product;
use App\Client; 
use App\User;
use App\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PurchaseController extends Controller
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


        // if(Auth::user()->user_role_iduser_role==4){
        //     $sales=Sale::where('client_idclient',Auth::user()->idmaster_user)->get();
        // }else{
        //     $sales=Sale::all();
        // }

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



        $userLogged=Auth::user();
        $products = Product::where('status', 1)->get();
        $productcategories=Product::select('product_category')->distinct()->orderBy('product_category')->get();
        $clients  = Client::get();
        
       
        return view('sales.makePurchase',['title'=>'Make Purchase',    
            'products'=>$products,
            'productcategories'=>$productcategories,
            'clients'=>$clients,
            'userLogged'=>$userLogged,
            'sales'=>$sales,
            ],compact('readOnly'));
    }


    //Save Sale Start
    public function purchaseSave(Request $request){


        $validator = \Validator::make($request->all(), [
            'client_id' => 'required',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:product,idproduct',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'client_id.required' => 'Client should be Selected!',
            'items.required' => 'Please add at least one product to the cart.',
            'items.*.product_id.required' => 'Product should be Selected!',
            'items.*.quantity.required' => 'Quantity should be entered!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

//Validation End

        $loginUser = Auth::user();

        // Wrapped everything in DB transaction
        DB::beginTransaction();

        try {
            $sale = new Sale();  // default pending appointments- not goes to payment table

            $sale->client_idclient = $request['client_id'];
            $sale->master_user_idmaster_user = $loginUser->idmaster_user;
            $sale->total_amount = 0;

            $sale->save();

            $total = 0;
            $lowStockWarnings = [];

            foreach ($request['items'] as $item) {
                    $product = Product::find($item['product_id']);

                    if (!$product) {
                        continue;
                    }

                    $quantity = (int) $item['quantity'];

                    // Strict Stock Validation
                    if ($quantity > $product->quantity) {
                        DB::rollBack();
                        return response()->json([
                            'error' => 'Cannot proceed. The requested quantity for "' . $product->product_name . '" exceeds the available stock (' . $product->quantity . ').'
                        ]);
                    }


                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;

                    SaleItem::create([
                        'sale_idsale'       => $sale->idsale,
                        'product_idproduct' => $product->idproduct,
                        'quantity'          => $quantity,
                        'unit_price'        => $product->price,
                        'subtotal'          => $subtotal,
                        'status'            => 0,
                    ]);

                    $product->quantity = $product->quantity - $quantity;
                    $product->save();

                    if ($product->quantity <= 5) {
                        $lowStockWarnings[] = $product->product_name . ' (remaining: ' . $product->quantity . ')';
                    }
                }

                $sale->status = 0;
                $sale->payment_type = 'PENDING';
                $sale->total_amount = $total;
                $sale->save();

                // Commit transaction
                DB::commit();


                return response()->json([
                    'success'  => 'Sale completed successfully',
                    'warnings' => $lowStockWarnings,
                ]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Something went wrong while saving the sale.']);
        }
    }

    //Save Sale ends


    public function showAmount(Request $request){

        $productId = $request['productId'];

     return Product::find($productId);

    }



    //method to filter services by category name
    public function getProductsByCategory(Request $request){

        $categoryName = $request['product_category'];

        $products  = Product::where('product_category', $categoryName)->where('status', 1) ->get();

    return response()->json($products);
    
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

