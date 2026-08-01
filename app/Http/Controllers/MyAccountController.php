<?php


namespace App\Http\Controllers;


use App\User;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    public function index(){

        $users = Auth::user();

        return view('my_account.myAccount', ['title'=>'My Account', 'users' => $users]);
    }



    public function getUserDetails(Request $request){

        return User::find($request['profile']);

    }





    public function updateUserDetails(Request $request) {


        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'lName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'dob' => 'required',
            // 'contactNo' => 'required|numeric|max:10|min:10',
            'contactNo' => 'required|numeric|digits:10',            
            'uName' => 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',



        ], [
            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'fName.regex' => 'First Name must contain letters only.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'lName.regex' => 'Last Name must contain letters only.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.numeric' =>  'Contact No must be a valid number.',
            // 'contactNo.max' => 'Contact No must be include 10 numbers.',
            // 'contactNo.min' => 'Contact No must be include 10 numbers.',
            'contactNo.digits'    => 'Contact No must be 10 numbers.',


            'dob.required' => 'DOB should be provided!',

            'uName.required' => 'Email should be provided!',
            'uName.regex'    => 'Valid Gmail addresses (@gmail.com) are allowed!',


        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);

        }

        // Always update master_user table
        $updateUser=User::find(Auth::user()->idmaster_user);

        $updateUser->first_name=$request['fName'];
        $updateUser->last_name=$request['lName'];
        $updateUser->dob=$request['dob'];
        $updateUser->contact_number=$request['contactNo'];
        $updateUser->user_name=$request['uName'];
        $updateUser->gender=$request['my-input-id'];

        $updateUser->save();


        // client - clients table
        if (Auth::user()->user_role_iduser_role == 4) {

            $updateClient = Client::where('master_user_idmaster_user', Auth::user()->idmaster_user)->first();

            if ($updateClient) {
                $updateClient->first_name = $request['fName'];
                $updateClient->last_name = $request['lName'];
                $updateClient->dob = $request['dob'];
                $updateClient->contact_number = $request['contactNo'];
                $updateClient->user_name = $request['uName'];
                $updateClient->gender = $request['my-input-id'];
                
                $updateClient->save();
            }
        }

        return response()->json(['success'=>'']);
    }








//Change Password Start

    public function changePassword(Request $request) {


            $validator = \Validator::make($request->all(), [

                'newPassword' => 'required',
                'confirmPassword' => 'required',

            ], [

                'newPassword.required' => 'New Password should be provided!',

                'confirmPassword.required' => 'Confirm Password should be provided!',


            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }


            $advanceEncryption=(new  \App\MyResources\AdvanceEncryption($request->get('newPassword'),"Nova6566",256));

            $changePassword=User::find(Auth::user()->idmaster_user);
            $changePassword->password= $advanceEncryption->encrypt();

            $changePassword->save();

            return response()->json(['success'=>'Saved']);


    }
//Change Password End

}