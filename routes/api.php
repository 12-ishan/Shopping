<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\CustomerController;

use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\ProductCategoryController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Public Api Routes
Route::post('/v1/customer-register', [CustomerController::class, 'customerRegister']);
Route::post('/v1/customer-login', [CustomerController::class, 'customerLogin']);


Route::get('/v1/product-category', [ProductCategoryController::class, 'getProductCategories']);
Route::get('/v1/get-products/{slug}', [ProductCategoryController::class, 'getProductByCategory']);



// Route::post('/v1/send-forgot-password-otp', [StudentController::class, 'sendForgotPasswordOtp']);
// Route::post('/v1/verify-forgot-password-otp', [StudentController::class, 'verifyForgotPasswordOtp']);
// Route::post('/v1/reset-password', [StudentController::class, 'resetPassword']);





Route::middleware('auth:sanctum')->group( function () {

    Route::get('/v1/my-profile', [CustomerController::class, 'myProfile']);

});