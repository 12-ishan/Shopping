<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderBilling;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $token = $request->bearerToken();
        $customerId = null;
        $sessionId = null;

        if ($token) {
            $tokenData = PersonalAccessToken::findToken($token);
            if ($tokenData && $tokenData->tokenable_type === Customer::class) {
                $customer = $tokenData->tokenable;
                $customerId = $customer->id;  
            }
        }

        if ($customerId) {
            $cart = Cart::where('customer_id', $customerId)->with('items')->first();
        } else {
            $sessionId = $request->session_id;
            $cart = Cart::where('session_id', $sessionId)->with('items')->first();
        }

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $totalAmount = $cart->total_amount;

        $order = new Order();
        $order->customer_id = $customerId;
        $order->session_id = $sessionId;
        $order->order_status = 'pending';
        $order->sort_order = 1;
        $order->increment('sort_order');
        $order->save();

        foreach ($cart->items as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product_price; 
            $orderItem->status = 1;
            $orderItem->sort_order = 1;
            $orderItem->increment('sort_order');
            $orderItem->save();
        }

        $orderBilling = new OrderBilling();
        $orderBilling->order_id = $order->id;
        $orderBilling->country = $request->country;
        $orderBilling->first_name = $request->first_name;
        $orderBilling->last_name = $request->last_name;
        $orderBilling->company_name = $request->company_name;
        $orderBilling->address = $request->address;
        $orderBilling->state = $request->state;
        $orderBilling->pin_code = $request->pin_code;
        $orderBilling->email = $request->email;
        $orderBilling->phone = $request->phone;
        $orderBilling->status = 1;
        $orderBilling->sort_order = 1;
        $orderBilling->increment('sort_order');
        $orderBilling->save();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $amount = $totalAmount * 100; 

        if ($amount < 100) { 
            return response()->json(['message' => 'Order amount less than minimum amount allowed'], 400);
        }

        $razorpayOrder = $api->order->create([
            'receipt'         => $order->id,
            'amount'          => $amount,
            'currency'        => 'INR',
            'payment_capture' => 1,
        ]);

        $order->razorpay_order_id = $razorpayOrder['id'];
        $order->save();

        return response()->json([
            'order_id' => $order->id,
            'razorpay_order_id' => $razorpayOrder['id'],
            'message' => 'Order placed successfully. Proceed to payment.',
        ]);
    }

    public function success(Request $request)
{
    try {
      
        $order = Order::where('id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->order_status = 'completed'; 
        $order->save();

        if ($order->customer_id) {
            $cart = Cart::where('customer_id', $order->customer_id)->first();
        } else {
            $cart = Cart::where('session_id', $order->session_id)->first();
        }

        if ($cart) {
            $cart->items()->delete(); 
            $cart->delete(); 
        }

        return response()->json(['message' => 'Payment stored successfully and cart data deleted']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
}
