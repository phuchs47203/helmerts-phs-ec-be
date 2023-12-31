<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Fruitcake\Cors\CorsMiddleware;

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

Route::get('/products/main-product/{id}', [ProductController::class, 'main_product']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products-newest', [ProductController::class, 'indexNewest']);

Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::get('/products-size-of-product/{id}', [ProductController::class, 'show']);
Route::get('/products/interested/{catId}', [ProductController::class, 'interested_product']);
Route::post('/products/filter', [ProductController::class, 'filters']);
Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Route::put('/products/{id}', [ProductController::class, 'update']);
// Route::patch('/products/{id}', [ProductController::class, 'update']);

Route::post('/product-category', [ProductCategoryController::class, 'store']);
Route::get('/product-category', [ProductCategoryController::class, 'index']);
Route::get('/product-category/{id}', [ProductCategoryController::class, 'show']);
Route::delete('/product-category/{id}', [ProductCategoryController::class, 'destroy']);
Route::post('/product-category/{id}', [ProductCategoryController::class, 'update']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::post('/orders/{id}', [OrderController::class, 'update']);
Route::get('/orders-user/{id}', [OrderController::class, 'showOrderUser']);
Route::get('/orders-belong-to-shipper/{id}', [OrderController::class, 'showUserBelongToShipper']);

Route::post('/update-order-by-shipper/{order_id}', [OrderController::class, 'confirmOrderByShipper']);
Route::post('/update-order-by-manager/{order_id}', [OrderController::class, 'confirmOrderByManger']);
Route::post('/cancel-order-by-user/{order_id}', [OrderController::class, 'cancelOrderByUser']);
Route::post('/cancel-order-by-shipper/{order_id}', [OrderController::class, 'cancelOrderByShipper']);
Route::post('/cancel-order-by-manager/{manager_id}/{order_id}', [OrderController::class, 'cancelOrderByManager']);

Route::post('/comments', [CommentController::class, 'storeAll']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{id}', [CommentController::class, 'show']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
Route::post('/comments/{id}', [CommentController::class, 'update']);

Route::post('/product-size', [ProductSizeController::class, 'store']);
Route::get('/product-size', [ProductSizeController::class, 'index']);
Route::get('/product-size/{id}', [ProductSizeController::class, 'show']);
Route::get('/product-list-size/{id}', [ProductSizeController::class, 'showProductSize']);
Route::delete('/product-size/{id}', [ProductSizeController::class, 'destroy']);
Route::post('/product-size/{id}', [ProductSizeController::class, 'update']);


Route::post('/order-details', [OrderDetailController::class, 'store']);
Route::get('/order-details', [OrderDetailController::class, 'index']);
Route::get('/order-details/{id}', [OrderDetailController::class, 'show']);
Route::get('/order-details-of-order/{id}', [OrderDetailController::class, 'showOrderDetails']);

// showOrderDetails

Route::delete('/order-details/{id}', [OrderDetailController::class, 'destroy']);
Route::post('/order-details/{id}', [OrderDetailController::class, 'update']);


// Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password-token', [AuthController::class, 'reset_password_token']);
Route::post('/verification-token', [AuthController::class, 'verification_token']);

// Route::post('/upload', function (Request $request) {
//     $imgurl = Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();
//     return $imgurl;
// });

//PROTECTED route

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::post('/products', [ProductController::class, 'store']);
    // Route::put('/products/{id}', [ProductController::class, 'update']);
    // Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/users', [UserController::class, 'show']);
    Route::post('/register-shipper', [AuthController::class, 'register_shipper']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users-user', [UserController::class, 'index_user']);
    Route::get('/users-shipper', [UserController::class, 'index_shipper']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
