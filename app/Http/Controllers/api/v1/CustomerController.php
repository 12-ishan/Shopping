<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Admin\Order;
use App\Models\Admin\OrderItem;
use App\Models\OrderBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;


class CustomerController extends Controller
{

public function customerRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8'
    ]);

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
           // 'customer' => $customerId,
        ];
    }
    else {
        $customerId = $checkCustomer->id;

        $response = [
            'message' => 'email already exist',
            'status' => 'error',
           // 'customer' => $customerId,
        ];
    }
    return response()->json($response, 201);
}

   
    public function customerLogin(Request $request)
    {
       
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
       
        if (Auth::guard('customer')->attempt($credentials)) {
            
            $request->session()->regenerate();
            $customer = Auth::guard('customer')->user();
        
            if ($customer->status == 1) {
               
               $token = $customer->createToken('auth_token')->plainTextToken;
        
                \Log::info('Generated Token: ' . $token);
    
                return response()->json([
                    'message' => 'Login successful',
                    'status' => '1',
                    'token' => $token,
                    //'customer' => $customer->id
                ]);
              
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
        $user = Auth::user();
    
        $orders = Order::where('customer_id', $user->id)->get();
    
        $ordersWithDetails = [];

        foreach ($orders as $order) {
            
            $firstOrderItem = OrderItem::where('order_id', $order->id)->first();
    
            $orderBilling = OrderBilling::where('order_id', $order->id)->first();
    
            $orderData = [
                'id' => $order->id,
                'order_status' => $order->order_status,
                'created_at' => $order->created_at,
                'order_items' => $firstOrderItem,  
                'order_billing' => $orderBilling
            ];
    
            $ordersWithDetails[] = $orderData;
        }
    
        return response()->json([
            'message' => 'my profile',
            'status' => '1',
            'customer' => $user,  
            'orders' => $ordersWithDetails  
        ], 200);
    }
   
    public function orderDetails(Request $request, $order_id){

        $user = Auth::user();

        $order = Order::with('orderItems', 'orderBilling')->where('customer_id', $user->id)->where('id', $order_id)->get();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found or does not belong to the authenticated user.',
            ], 404);
        }

        return response()->json([
            'orderDetail' => $order,
        ]);
    }


    public function logout(Request $request)
{
    // Revoke the token that was used to authenticate the current request
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully',
        'status' => '1',
    ], 200);
}
  
    // public function customerLogin(Request $request)
    // {
    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|min:8',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'error' => $validator->errors()
    //         ], 422);
    //     }

    //     $credentials = $request->only('email', 'password');

    //     // Attempt to log in the customer
    //     if (Auth::guard('customer')->attempt($credentials)) {
    //         \Log::info('Session ID: ' . $request->session()->getId());
    //         $request->session()->regenerate();

    //         $customer = Auth::guard('customer')->user();

    //         if ($customer->status == 1) {
    //             return response()->json([
    //                 'message' => 'Login successful',
    //                 'status' => '1'
    //             ]);
    //         } else {
    //             // Log out if account is inactive
    //             Auth::guard('customer')->logout();

    //             return response()->json([
    //                 'message' => 'Your account is inactive',
    //                 'status' => '0'
    //             ], 403);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => 'Invalid credentials',
    //             'status' => '0'
    //         ], 401);
    //     }
    // }

    // public function myProfile(Request $request)
    // {
    //     \Log::info('Session ID: ' . $request->session()->getId());
    //     // Your profile logic here
    //     $user = Auth::guard('customer')->user();

    //     return response()->json(['user' => $user]);
    // }


 
}





    



   
   