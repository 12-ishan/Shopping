<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;


class CustomerController extends Controller
{

public function customerRegister(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        $errors = $validator->errors()->all();
        return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
    }

    $checkCustomer = Customer::where('email', $request->email)->first();
    
    if (empty($checkCustomer)) {
       
        $customer = new Customer();
        $customer->username = $request->input('username');
        $customer->email = $request->input('email');
        $customer->password = Hash::make($request->input('password'));
        $customer->status = 1;
        $customer->sort_order = 1;
        $customer->increment('sort_order');
        $customer->save();

        $customerId = $customer->id;

        $response = [
            'message' => 'Registered successfully',
            'status' => 'success',
            'customer' => $customerId,
        ];
    }
    else {
        $customerId = $checkCustomer->id;

        $response = [
            'message' => 'email already exist',
            'status' => 'error',
            'customer' => $customerId,
        ];
    }
    return response()->json($response, 201);
}

   

   
    public function customerLogin(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
    
        $credentials = $request->only('email', 'password');
    
        // Attempt to log in the customer
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
    
            $customer = Auth::guard('customer')->user();
    
            if ($customer->status == 1) {
                // Generate a token
               // $token = $customer->createToken('Personal Access Token')->plainTextToken;
    
               $token = $customer->createToken('auth_token')->plainTextToken;

                \Log::info('Generated Token: ' . $token);
    
                // Set the token as an HttpOnly cookie
               // $cookie = cookie('token', $token, 60, '/', null, false, true);
    
                return response()->json([
                    'message' => 'Login successful',
                    'status' => '1',
                ])->withCookie(
                    cookie('sanctum_token', $token, 60 * 24, null, null, true, true, false, 'None')
                );
            } else {
                // Log out if account is inactive
                Auth::guard('customer')->logout();
    
                return response()->json([
                    'message' => 'Your account is inactive',
                    'status' => '0'
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => '0'
            ], 401);
        }
    }
    
    public function myProfile(Request $request)
    {
        // Access the token from the cookie
        $token = $request->cookie('sanctum_token');

        // Log the token
        \Log::info('Sanctum Token: ' . $token);

        return response()->json([
            'message' => 'my profile',
            'status' => '1',
            'token' => $token
        ], 200);
    }
  
    

 
}





    



   
   

