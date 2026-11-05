<?php


namespace App\Http\Controllers;


use App\ContactUs;
use Illuminate\Http\Request;


class ClientInterfaceController extends controller
{

    public function index()
    {
        return view('clientInterface', ['title' => 'clientInterface']);
    }



    // save contactUs 
    public function saveContactUs(Request $request)
    {
        // validation data
        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|max:115|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'subject' => 'required',
            'message' => 'required',


        ], [    // validation errors 
            'fName.required' => 'Name should be provided!',
            'fName.max' => 'Name must be less than 115 characters.',
            'fName.regex' => 'First Name must contain letters only.',

            'email.required' => 'Email should be provided!',
            'email.max' => 'Email must be less than 115 characters.',
            'email.regex'    => 'Valid Gmail addresses (@gmail.com) are allowed!',

            'subject.required' => 'Subject should be provided!',

            'message.required' => 'Message should be provided!',

        ]);

        // pass the validation errors to front end
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        }

        //create object from modal
        $saveContact = new ContactUs();

        
        $saveContact->name = strtoupper($request['fName']);    //strtoupper - convert capital letters and save to db
        $saveContact->email = $request['email'];
        $saveContact->subject = $request['subject'];
        $saveContact->message = $request['message'];

        $saveContact->save();


        return redirect()->back()->with('success', 'Message sent successfully!');

    }



}