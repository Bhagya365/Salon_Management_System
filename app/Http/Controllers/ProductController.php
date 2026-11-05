<?php


namespace App\Http\Controllers;

use App\Product;
use App\Attendance;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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


        $products = Product::get();

        return view('category.product',['title'=>'products', 'products'=>$products],compact('products', 'readOnly'));
    }







    //Save Product Start
    public function productSave(Request $request){


        $productcategory=$request['productcategory'];
        $product=$request['product'];
        $price=$request['price'];
        $quantity=$request['quantity'];



    //Validation Start
        $validator = \Validator::make($request->all(), [

            'productcategory'  =>   'required|max:80|regex:/^[^0-9]+$/',
            'product'  =>   'required|max:80',
            'price'    =>   'required|numeric',
            'quantity'    =>   'required|numeric',

        ], [

            'productcategory.required' =>  'Product Category should be provided!',
            'productcategory.max'  =>  'Product Category must be less than 80 characters long.',
            'productcategory.regex'  =>  'Product Category must contain letters only.',

            'product.required' =>  'Product should be provided!',
            'product.max'  =>  'Product must be less than 80 characters long.',

            'price.required'   =>  'Price should be provided!',
            'price.numeric'    =>  'Price must be a valid number.',

            'quantity.required'   =>  'Quantity should be provided!',
            'quantity.numeric'    =>  'Quantity must be a valid number.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

    //Validation End


    // Existing product start
        $existingProduct = Product::where('product_category', strtoupper($productcategory))
                                        ->where('product_name', strtoupper($product))
                                        ->first();

            if ($existingProduct) {
                return response()->json([
                    'errors' => [
                        'product' => ['This product already exists! Please use "Update Product" to add more quantity.']
                    ]
                ]);
            }
    // Existing product end


        $save=new Product();

        $save->product_category=strtoupper($productcategory);
        $save->product_name=strtoupper($product);
        $save->price=$price;
        $save->quantity=$quantity;
        $save->status=1;

        $save->save();

        return response()->json(['success'=>'Product Saved']);
    }
    //Save Product End








    //Update Product Start
    public function productUpdate(Request $request){

        $hiddenProductId = $request['hiddenProductId'];
        $productcategory=$request['productcategory'];
        $product = $request['product'];
        $price = $request['price'];
        $quantity = $request['quantity'];


   //Validation start
        $validator = \Validator::make($request->all(), [

            'productcategory'  =>   'required|max:80|regex:/^[^0-9]+$/',
            'product' => 'required|max:80',
            'price'    => 'required|numeric',
            'quantity'    => 'required|numeric',

        ], [

            'productcategory.required' =>  'Product Category should be provided!',
            'productcategory.max'  =>  'Product Category must be less than 80 characters long.',
            'productcategory.regex'  =>  'Product Category must contain letters only.',


            'product.required' => 'Product should be provided!',
            'product.max' => 'Product must be less than 80 characters long.',

            'price.required'   =>  'Price should be provided!',
            'price.numeric'    =>  'Price must be a valid number.',

            'quantity.required'   =>  'Quantity should be provided!',
            'quantity.numeric'    =>  'Quantity must be a valid number.'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    // Validation end




        $update = Product::find($hiddenProductId);
        $update->product_category=strtoupper($productcategory);
        $update->product_name=strtoupper($product);
        $update->price=$price;

        $update->quantity=$quantity;
        // $update->quantity= $update->quantity + $quantity;

        $update->save();

        return response()->json(['success'=>'Product Updated']);
    }
//Update Product End









// //Delete Product Start
    public function productDelete(Request $request){
        $id=$request['id'];
        $update=Product::find($id);

        $update->delete();

        return response()->json(['success'=>'Product Deleted']);
    }
}
//Delete Product End