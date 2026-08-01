<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{

    public function login(Request $request)
    {
        // validations
        $this->validate($request, ['username' => 'required|email', 'password' => 'required|min:3']);

        $advanceEncryption=(new  \App\MyResources\AdvanceEncryption($request->get('password'),"Nova6566",256));

        // get & compare with db data and user input data
        $user = User::where('user_name', $request->get('username'))->where('password',$advanceEncryption->encrypt())->exists();
        
        // username & password are matched
        if ($user==true){
            // all data of $user variable pass to $userData variable to get first row of the db table
            $userData=User::where('user_name', $request->get('username'))->where('password',$advanceEncryption->encrypt())->first();

            // status is 1 - give log access to user
            if ($userData->status==1){
                Auth::login($userData);  // give authenticating
                return redirect('/');    // '/' - index page
            }

            // status is 0 - dont give access to login
            else if($userData->status==0){
                return back()->with('warning', 'User has been suspended! Contact your System Administrator.');
            }

        }
        // username & password are not matched
        else{
            return back()->with('error', 'Incorrect login details! Check Username and Password');
        }

    }







    public function signup(){

        return view('clientSignup',['title'=>'Sign Up']);
    }






    public function logoutNow(Request $request){
        //Auth::logout();
        $request->session()->invalidate();   // set session invalidate
        return redirect('/clientInterface');    // this is the route
    }



}
