<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Admin\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Add this line



class CartController extends Controller
{

    // public function updateTotalAmount(Cart $cart)
    // {
    //     $totalAmount = 0;

    //     foreach ($cart->items as $item) {
    //         if ($item->product->type == 1) {
    //             // Fetch the price using the variation_id
    //             if ($item->type == 1) {
    //                 // Check if the variation_id exists and fetch the variation price
    //                 if ($item->variation_id) {
    //                     // Assuming `ProductVariation` model is related and `product_id` matches the item product
    //                     $variation = ProductVariation::where('id', $item->variation_id)
    //                         ->where('product_id', $item->product_id)
    //                         ->first();
            
    //                     $price = $variation ? $variation->price : $item->product_price; // Use variation price if found, otherwise fallback to product price
    //                 } else {
    //                     // Fallback to product price if no variation_id
    //                     $price = $item->product_price;
    //                 }
    //             } else {
    //                 // If the product is not a variation type, just use the product price
    //                 $price = $item->product_price;
    //             }
            
    //             // Calculate total amount for this item
    //             $totalAmount += $item->quantity * $price;
    //     }
    // }

    //     $cart->total_amount = $totalAmount;
    //     $cart->save();
    // }

    public function updateTotalAmount(Cart $cart)
{
    $totalAmount = 0;

    foreach ($cart->items as $item) {
        if ($item->product->type == 1 && $item->product_variation__id) {
            
            $variation = ProductVariation::where('id', $item->product_variation__id)
                ->where('product_id', $item->product_id)
                ->first();

            $price = $variation ? $variation->price : $item->product->price;
        } else {
            
            $price = $item->product->price;
        }

       
        $totalAmount += $item->quantity * $price;
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
        $guestId = $request->sessionId;//Session::get('session_id');

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
            $cartItem->product_variation__id = $request->variation_id;
            $cartItem->quantity += $request->quantity;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->increment('sort_order');
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->product_id = $request->product_id;
            $cartItem->product_variation__id = $request->variation_id;
            $cartItem->quantity = $request->quantity;
            $cartItem->cart_id = $cart->id;
            $cartItem->status = 1;
            $cartItem->sort_order = 1;
            $cartItem->increment('sort_order');
            $cartItem->save();
        }

        $this->updateTotalAmount($cart);
    
        return response()->json(['message' => 'success',
        'product_id' => $cartItem->product_id,
    ], 200);
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

            $variationDetails = null;
           
        if ($product->type == 1 && $item->product_variation__id) {
            $selectedVariation = ProductVariation::where('id', $item->product_variation__id)->first();
            
            if ($selectedVariation) {
                $variationAttributes = $selectedVariation->variationAttribute; 

                $variationDetails['price'] = $selectedVariation->price;
                
                foreach ($variationAttributes as $variationAttribute) {
                    $variationDetails[] = [
                        'attribute_id' => $variationAttribute->attributeOption->attribute_id,
                        'attribute_name' => $variationAttribute->attributeOption->attribute->name,
                        'option_id' => $variationAttribute->attributes_options_id,
                        'option_name' => $variationAttribute->attributeOption->value,
                        
                    ];
                }
            }
        }

    
            return [
                'id' => $item->id,
                'cart_id' => $item->cart_id,
                'product_id' => $item->product_id,
                'variation_id' => $item->product_variation__id,
                'quantity' => $item->quantity,
                'status' => $item->status,
                'product' => $modifiedProduct,  
                'selected_variation' => $variationDetails,
               // 'VariationPrice' => $selectedVariationPrice->price
                
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

     public function updateCart(Request $request)
    {
         $cart = $this->getCart($request);
    
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
    
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
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
    
        $cartItem = $cart->items()->where('product_id', $cartItemId)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
    
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
            $cartItem->product_variation__id = $item['variation_id'];
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