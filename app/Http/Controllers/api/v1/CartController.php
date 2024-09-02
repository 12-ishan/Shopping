<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Add this line

// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Validator;

class CartController extends Controller
{

    public function updateTotalAmount(Cart $cart)
    {
        $totalAmount = 0;

        foreach ($cart->items as $item) {
            $totalAmount += $item->quantity * $item->product->price;
        }

        $cart->total_amount = $totalAmount;
        $cart->save();
    }

    public function getCart(Request $request)
{
    if (Auth::check()) {
        $userId = Auth::id();

        $cart = Cart::where('customer_id', $userId)->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->customer_id = $userId;
            $cart->status = 1;
            $cart->sort_order = 1;
            $cart->save();
        }

        return $cart;
    } else {
        $guestId = Session::get('session_id');

        if (!$guestId) {
            $guestId = uniqid('guest_', true);
            Session::put('session_id', $guestId);
        }

        $cart = Cart::where('session_id', $guestId)->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->session_id = $guestId;
            $cart->status = 1;
            $cart->sort_order = 1;
            $cart->save();
        }

        return $cart;
    }
}
   
    public function addToCart(Request $request)
    {
        $cart = $this->getCart($request);
    
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
    
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->increment('sort_order');
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->product_id = $request->product_id;
            $cartItem->quantity = $request->quantity;
            $cartItem->cart_id = $cart->id;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->increment('sort_order');
            $cartItem->save();
        }

        $this->updateTotalAmount($cart);
    
        return response()->json(['response' => "success"], 200);
    }

    public function fetchCart(Request $request)
    {
        $cart = $this->getCart($request);
    
        $cartItems = cartItem::where('cart_id', $cart->id)
            ->with('product')
            ->get();
    
        $modifiedCartItems = $cartItems->map(function ($item) {
            $product = $item->product; 
    
            $modifiedProduct = $this->getModifiedProducts($product->toArray());
    
            return [
                'id' => $item->id,
                'cart_id' => $item->cart_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'status' => $item->status,
                'product' => $modifiedProduct,  
            ];
        });
    
        return response()->json(['cart' => $modifiedCartItems], 200);
    }
    
    protected function getModifiedProducts($array)
    {
        $modifiedArray = [
            'id' => $array['id'],
            'name' => $array['name'],
            'slug' => $array['slug'],
            'price' => $array['price'],
            'description' => $array['description'],
            'status' => $array['status'],
            'image' => url('/') . "/uploads/productImage/" . getMediaName($array['imageId']),  
        ];
    
        unset($modifiedArray['created_at']);
        unset($modifiedArray['updated_at']);
        unset($modifiedArray['sort_order']);
    
        return $modifiedArray;
    }

     public function subtractItemFromCart(Request $request)
    {
         $cart = $this->getCart($request);
    
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
    
        if ($cartItem) {
            $cartItem->quantity -= $request->quantity;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->increment('sort_order');
            $cartItem->save();
        }

        $this->updateTotalAmount($cart);

       return response()->json(['cartItem' => $cartItem], 200);
    }
    

    public function removeFromCart(Request $request, $cartItemId)
{
    $cart = $this->getCart($request);

    $cartItem = $cart->items()->findOrFail($cartItemId);

    $cartItem->delete();

    $this->updateTotalAmount($cart);

    return response()->json(['response' => 'row deleted'], 200);
}

public function syncCart(Request $request)
{
    $cart = $this->getCart($request);

    $sessionId = $cart->session_id;
    $cart = Cart::where('session_id', $sessionId)->first();

    if ($cart) {
      
        $cart->items()->delete();

        foreach ($request->cart as $item) {
            $cartItem = new CartItem();
            $cartItem->product_id = $item['product_id']; 
            $cartItem->quantity = $item['quantity']; 
            $cartItem->cart_id = $cart->id;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->save();

            $cartItem->increment('sort_order');
        }

        $this->updateTotalAmount($cart);
    }
    return response()->json(['response' => $sessionId]);
}

}