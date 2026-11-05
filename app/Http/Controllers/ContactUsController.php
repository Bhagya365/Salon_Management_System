<?php


namespace App\Http\Controllers;


use App\ContactUs;

class ContactUsController extends Controller
{

    public function index(){

        $contacts = ContactUs::get();


        return view('contact_us.contactUs',['title'=>'Contact Us', 'contacts'=>$contacts]);
    }


}
