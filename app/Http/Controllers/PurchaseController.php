<?php


namespace App\Http\Controllers;


use App\Sale;
use App\SaleItem;
use App\Product;
use App\Client; 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PurchaseController extends Controller
{
    public function index(){


        if(Auth::user()->user_role_iduser_role==4){
            $sales=Sale::where('client_idclient',Auth::user()->idmaster_user)->get();
        }else{
            $sales=Sale::all();
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
            ]);
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

}