<?php


namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller

{
    public function index(){


        $userClients = User::where('user_role_iduser_role',4)->get();

        return view('client_management.clientManagement',['title'=>'Client Management', 'userClients'=>$userClients]);
    }





//Save Client by Sign Up Start
    public function saveClient(Request $request){

        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'lName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'contactNo' => 'required|numeric|digits:10',
            'gender' => 'required',
            'date' => 'required',
            'username' => 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'password' => 'required|min:6',

        ], [
            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'fName.regex' => 'First Name must contain letters only.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'lName.regex' => 'Last Name must contain letters only.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.numeric' =>  'Contact No must be a valid number.',
            'contactNo.digits'    => 'Contact No must be 10 numbers.',

            'gender.required' => 'Gender should be provided!',

            'date.required' => 'DOB should be provided!',

            'username.required' => 'Email should be provided!',
            'username.regex'    => 'Valid Gmail addresses (@gmail.com) are allowed!',

            'password.required' => 'Password should be provided.',
            'password.min' => 'Password must be include minimum 6 characters.',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        }


        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));

        $saveUser = new User();

        $saveUser->first_name = strtoupper($request['fName']);
        $saveUser->last_name = strtoupper($request['lName']);
        $saveUser->contact_number = $request['contactNo'];
        $saveUser->gender = $request['gender'];
        $saveUser->dob = $request['date'];
        $saveUser->user_name=strtolower($request['username']);
        $saveUser->password = $advanceEncryption->encrypt();
        $saveUser->status = 1;
        $saveUser->user_role_iduser_role = 4;

        $saveUser->save();



        $saveClient=new Client();

        $saveClient->first_name = strtoupper($request['fName']);
        $saveClient->last_name = strtoupper($request['lName']);
        $saveClient->contact_number = $request['contactNo'];
        $saveClient->gender = $request['gender'];
        $saveClient->dob = $request['date'];
        $saveClient->user_name = strtolower($request['username']);
        $saveClient->master_user_idmaster_user =$saveUser->idmaster_user;

        $saveClient->save();



        return response()->json(['success' => 'Client saved successfully.']);
    }
//Save Client by Sign Up End






//Save Client by Admin Start
    public function saveClientByAdmin(Request $request){


        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'lName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'contactNo' => 'required|numeric|digits:10',
            'gender' => 'required',
            'dob' => 'required',
            'username' => 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'password' => 'required|min:6',

        ], [


            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'fName.regex' => 'First Name must contain letters only.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'lName.regex' => 'Last Name must contain letters only.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.numeric' =>  'Contact No must be a valid number.',
            'contactNo.digits'    => 'Contact No must be 10 numbers.',

            'gender.required' => 'Gender should be provided!',

            'dob.required' => 'DOB should be provided!',

            'username.required' => 'Email should be provided!',
            'username.regex'    => 'Valid Gmail addresses (@gmail.com) are allowed!',

            'password.required' => 'Password should be provided.',
            'password.min' => 'Password must be include minimum 6 characters.',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        }


        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));

        $saveUser = new User();

        $saveUser->first_name = strtoupper($request['fName']);
        $saveUser->last_name = strtoupper($request['lName']);
        $saveUser->contact_number = $request['contactNo'];
        $saveUser->gender = $request['gender'];
        $saveUser->dob = $request['dob'];
        $saveUser->user_name=strtolower($request['username']);
        $saveUser->password = $advanceEncryption->encrypt();
        $saveUser->status = 1;
        $saveUser->user_role_iduser_role = 4;

        $saveUser->save();



        $saveClient=new Client();

        $saveClient->first_name = strtoupper($request['fName']);
        $saveClient->last_name = strtoupper($request['lName']);
        $saveClient->contact_number = $request['contactNo'];
        $saveClient->gender = $request['gender'];
        $saveClient->dob = $request['dob'];
        $saveClient->user_name = strtolower($request['username']);
        $saveClient->master_user_idmaster_user =$saveUser->idmaster_user;

        $saveClient->save();



        return response()->json(['success' => 'Client Saved Successfully.']);

    }
    //Save Client by Admin End






    //Update Client Start
    public function updateClient(Request $request){

        $hiddenUserId = $request['hiddenUserId'];

        $firstName = $request['firstName'];
        $lastName = $request['lastName'];
        $contactNo = $request['contactNo'];
        $email = $request['email'];



        //Validation
        $validator = \Validator::make($request->all(), [

            'firstName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'lastName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'contactNo' => 'required|numeric|digits:10',
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',

        ], [
            'firstName.required' => 'First Name should be provided!',
            'firstName.max' => 'First Name must be less than 115 characters.',
            'firstName.regex' => 'First Name must contain letters only.',

            'lastName.required' => 'Last Name should be provided!',
            'lastName.max' => 'Last Name must be less than 115 characters.',
            'lastName.regex' => 'Last Name must contain letters only.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.numeric' =>  'Contact No must be a valid number.',
            'contactNo.digits'    => 'Contact No must be 10 numbers.',

            'email.required' => 'Email should be provided!',
            'email.regex'    => 'Valid Gmail addresses (@gmail.com) are allowed!'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }



        $updateUser = User::find($hiddenUserId);

        $updateUser->first_name=strtoupper($firstName);
        $updateUser->last_name=strtoupper($lastName);
        $updateUser->contact_number=$contactNo;
        $updateUser->user_name=$email;

        $updateUser->save();



        $updateClient = Client::where('master_user_idmaster_user',$hiddenUserId)->first();

        $updateClient->first_name=strtoupper($firstName);
        $updateClient->last_name=strtoupper($lastName);
        $updateClient->contact_number=$contactNo;
        $updateClient->user_name=$email;

        $updateClient->save();



        return response()->json(['success'=>'Client Updated']);

    }
//Update Client End









}