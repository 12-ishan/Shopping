<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Admin\ProductVariation;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Add this line



class WishListController extends Controller
{

    
    public function addToWishList(Request $request)
    {
        
        $user = auth()->user();

        $wishListItem = WishList::where('customer_id', $user->id)
                                ->where('product_id', $request->product_id)
                                ->where('variation_id', $request->variation_id)
                                ->first();
        
        if ($wishListItem) {
            return response()->json(['message' => 'Product already in wish list'], 409);
        }

        $wishListItem = new WishList();
        $wishListItem->customer_id = $user->id;
        $wishListItem->product_id = $request->product_id;
        $wishListItem->variation_id = $request->variation_id;
       // $wishListItem->quantity = $request->quantity;
        $wishListItem->status = 1;
        $wishListItem->sort_order = 1;
        $wishListItem->increment('sort_order');
        $wishListItem->save();

        return response()->json(['message' => 'Product added to wish list successfully!'], 200);
    }



    public function fetchWishList(Request $request)
    {
        $user = auth()->user();
    
        $wishListItems = WishList::where('customer_id', $user->id)
            ->with('product')
            ->get();
    
        $modifiedWishLitItems = $wishListItems->map(function ($item) {
            $product = $item->product; 
    
            $modifiedProduct = $this->getModifiedProducts($product->toArray());

            $variationDetails = null;
           
        if ($product->type == 1 && $item->variation_id) {
            $selectedVariation = ProductVariation::where('id', $item->variation_id)->first();
           // print_r( $selectedVariation);
            
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
                // 'cart_id' => $item->cart_id,
                'product_id' => $item->product_id,
                'variation_id' => $item->variation_id,
                'quantity' => $item->quantity,
                'status' => $item->status,
                'product' => $modifiedProduct,  
                'selected_variation' => $variationDetails,
                //'VariationPrice' => $selectedVariationPrice->price
                
            ];
        });
    
        return response()->json(['wishlist' => $modifiedWishLitItems], 200);
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

    
    

    public function removeFromWishList(Request $request, $wishListId)
{
    try {
       
        $wishlistItem = Wishlist::findOrFail($wishListId);

        if ($wishlistItem->customer_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $wishlistItem->delete();

        return response()->json(['message' => 'Item removed from wishlist successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to remove item from wishlist.'], 500);
    }
}




}