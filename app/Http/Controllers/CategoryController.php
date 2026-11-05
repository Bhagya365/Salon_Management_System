<?php


namespace App\Http\Controllers;

use App\Category;
use App\Attendance;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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


        $categories = Category::get();

        return view('category.category',['title'=>'Categories', 'categories'=>$categories],compact('categories', 'readOnly'));
    }







    //Save Category Start
    public function categorySave(Request $request){


        $servicecategory=$request['servicecategory'];
        $category=$request['category'];
        $amount=$request['amount'];



    //Validation Start
        $validator = \Validator::make($request->all(), [

            'servicecategory'  =>   'required|max:80|regex:/^[^0-9]+$/',
            'category'  =>   'required|max:80|regex:/^[^0-9]+$/',
            'amount'    =>   'required|numeric',

        ], [

            'servicecategory.required' =>  'Category should be provided!',
            'servicecategory.max'  =>  'Category must be less than 80 characters long.',
            'servicecategory.regex'  =>  'Category must contain letters only.',

            'category.required' =>  'Service should be provided!',
            'category.max'  =>  'Service must be less than 80 characters long.',
            'category.regex'  =>  'Service must contain letters only.',

            'amount.required'   =>  'Amount should be provided!'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

    //Validation End


    // Existing product start
        $existingService = Category::where('category_name', strtoupper($servicecategory))
                                        ->where('service_name', strtoupper($category))
                                        ->first();

            if ($existingService) {
                return response()->json([
                    'errors' => [
                        'category' => ['This service already exists!']
                    ]
                ]);
            }
    // Existing product end


        $save=new Category();

        $save->category_name=strtoupper($servicecategory);
        $save->service_name=strtoupper($category);
        $save->amount=$amount;
        $save->status=1;

        $save->save();

        return response()->json(['success'=>'Service Saved']);
    }
    //Save Category End








    //Update Category Start
    public function categoryUpdate(Request $request){

        $hiddenCategoryId = $request['hiddenCategoryId'];
        $servicecategory=$request['servicecategory'];
        $category = $request['category'];
        $amount = $request['amount'];


   //Validation start
        $validator = \Validator::make($request->all(), [

            'servicecategory'  =>   'required|max:80|regex:/^[^0-9]+$/',
            'category' => 'required|max:80|max:80|regex:/^[^0-9]+$/',
            'amount'    => 'required|numeric',

        ], [

            'servicecategory.required' =>  'Category should be provided!',
            'servicecategory.max'  =>  'Category must be less than 80 characters long.',
            'servicecategory.regex'  =>  'Category must contain letters only.',


            'category.required' => 'Service should be provided!',
            'category.max' => 'Service must be less than 80 characters long.',
            'category.regex' => 'Service must contain letters only.',

            'amount.required'   =>  'Amount should be provided!',
            'amount.numeric'    =>  'Amount must be a valid number.'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    //Validation end




        $update = Category::find($hiddenCategoryId);
        $update->category_name=strtoupper($servicecategory);
        $update->service_name=strtoupper($category);
        $update->amount=$amount;

        $update->save();

        return response()->json(['success'=>'Service Updated']);
    }
//Update Category End









//Delete Category Start
    public function categoryDelete(Request $request){
        $id=$request['id'];
        $update=Category::find($id);

        $update->delete();

        return response()->json(['success'=>'Service Deleted']);
    }
}
//Delete Category End