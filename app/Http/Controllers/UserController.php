<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = User::whereIn('user_role_iduser_role',[2,3])->get(); //Get users where User Roles are 2 and 3

        return view('user_management.userManagement',['title'=>'User Management', 'users'=>$users]);
    }



//Save User Start
    public function saveUser(Request $request){


        $validator = \Validator::make($request->all(), [

            'userType' => 'required',
            'fName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'lName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'contactNo' => 'required|numeric|digits:10',
            'gender' => 'required',
            'dob' => 'required',
            'username' => 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'password' => 'required|min:6',

        ], [

            'userType.required' => 'User Type should be provided!',

            'fName.required' => 'First Name should be provided!',
            'fName.max' => 'First Name must be less than 115 characters.',
            'fName.regex' => 'First Name must contain letters only.',

            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'lName.regex' => 'Last Name must contain letters only.',

            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.digits'    => 'Contact No must be 10 numbers.',
            'contactNo.numeric' =>  'Contact No must be a valid number.',

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
        $saveUser->user_role_iduser_role = $request['userType'];


        $saveUser->save();


        return response()->json(['success' => 'User Saved Successfully.']);

    }
    //Save User End






    //Update User Start
    public function updateUser(Request $request){

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



        $update = User::find($hiddenUserId);

        $update->first_name=strtoupper($firstName);
        $update->last_name=strtoupper($lastName);
        $update->contact_number=$contactNo;
        $update->user_name=$email;

        $update->save();

        return response()->json(['success'=>'User Updated']);
    }
//Update User End







}