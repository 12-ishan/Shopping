<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ContactController extends Controller
{
    //
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
          ]);
  
          if ($validator->fails()) {
              $errors = $validator->errors()->all();
              return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
          }
  
          $contact = new Contact();
  
          $contact->name = $request->input('name');
          $contact->email = $request->input('email');
          $contact->phone = $request->input('phone');
          $contact->subject = $request->input('subject');
          $contact->message = $request->input('message');
         
          $contact->status = 1;
          $contact->sortOrder = 1;
  
          $contact->increment('sortOrder');
  
          $contact->save();
  
          $response = [
              'message' => 'contact inserted',
              'status' => '1'
          ];
  
          return response()->json($response, 201);
    }    
}


   
   

