<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;



class CouponController extends Controller
{
    //
    public function couponDetails(Request $request)
    {
        $checkCoupon = Coupon::where('coupon_code', $request->couponCode)
                             ->where('status', 1)
                             ->first();
    
        if (empty($checkCoupon)) {

            $response = [
                'message' => 'coupon code is not valid',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'amount' => $checkCoupon->discount_amount,
                'message' => 'coupon applied',
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    }    
}


   
   

