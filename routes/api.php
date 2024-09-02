<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\CustomerController;

use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\ProductCategoryController;
use App\Http\Controllers\api\v1\ProductDetailController;
use App\Http\Controllers\api\v1\CartController;
use App\Http\Controllers\api\v1\CheckoutController;
// use Illuminate\Session\Middleware\StartSession;
// use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

// use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
//     Route::post('/v1/customer-login', [CustomerController::class, 'customerLogin'])
//         ->middleware([AddQueuedCookiesToResponse::class, StartSession::class]);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('/v1/my-profile', [CustomerController::class, 'myProfile']);
//     });
// });


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

Route::get('/v1/product-detail/{categorySlug}/{productSlug}', [ProductDetailController::class, 'fetchProductDetails']);



// Route::post('/v1/send-forgot-password-otp', [StudentController::class, 'sendForgotPasswordOtp']);
// Route::post('/v1/verify-forgot-password-otp', [StudentController::class, 'verifyForgotPasswordOtp']);
// Route::post('/v1/reset-password', [StudentController::class, 'resetPassword']);






// Route::post('/v1/customer-login', [CustomerController::class, 'customerLogin']);

Route::middleware('auth:sanctum')->group( function () {

    Route::get('/v1/my-profile', [CustomerController::class, 'myProfile']);
    Route::post('/v1/logout', [CustomerController::class, 'logout']);

    Route::post('/v1/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/v1/cart/remove/{cartItemId}', [CartController::class, 'removeFromCart']);
    Route::get('/v1/cart/fetch', [CartController::class, 'fetchCart']);
    Route::post('/v1/cart/subtract', [CartController::class, 'subtractItemFromCart']);

});

Route::post('/v1/cart/sync', [CartController::class, 'syncCart']);
Route::post('/v1/checkout', [CheckoutController::class, 'checkout']);
Route::post('/v1/success-payment', [CheckoutController::class, 'success']);

// Routes for guests
//Route::post('/v1/cart/add', [CartController::class, 'addToCart']);
// Route::post('/v1/cart/update/{productId}', [CartController::class, 'updateCartItem']);
// Route::post('/v1/cart/remove/{productId}', [CartController::class, 'removeFromCart']);
// Route::post('/v1/cart/sync', [CartController::class, 'syncCart']);
// Route::post('/v1/cart/checkout', [CartController::class, 'checkout']);
// Route::get('/v1/cart', [CartController::class, 'fetchCart']);

// Route::group(['middleware' => ['api', 'session']], function () {
//     Route::post('/v1/customer-login', [CustomerController::class, 'customerLogin']);
//     // Other routes
//     Route::middleware('auth:sanctum')->group( function () {

//         Route::get('/v1/my-profile', [CustomerController::class, 'myProfile']);
    
//     });
// });