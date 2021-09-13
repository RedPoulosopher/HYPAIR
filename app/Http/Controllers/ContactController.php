<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;


 class ContactController extends Controller
 {
     public function contact()
     {
         return view('contact');
        
     }
     /** * Show the application dashboard. * * @return \Illuminate\Http\Response */
     public function contactPost(Request $request)
     {
         $this->validate($request, [
            'objet' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        
         Mail::send(
            'mails.contact',
            array(
                'objet' => $request->get('objet'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ),
            function ($message) use ($request){
                $message->from($request->get('email'));
                $message->to('marc.bresson@etu.imt-lille-douai.fr', 'AIR')->subject($request->get('objet'));
            }
         );
         
         return back()->with('success');
     }
 }
