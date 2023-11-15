<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products/filter', [ProductController::class, 'filters']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);

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

Route::post('/comments', [CommentController::class, 'store']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{id}', [CommentController::class, 'show']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
Route::post('/comments/{id}', [CommentController::class, 'update']);

Route::post('/order-details', [OrderDetailController::class, 'store']);
Route::get('/order-details', [OrderDetailController::class, 'index']);
Route::get('/order-details/{id}', [OrderDetailController::class, 'show']);
Route::delete('/order-details/{id}', [OrderDetailController::class, 'destroy']);
Route::post('/order-details/{id}', [OrderDetailController::class, 'update']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/users/{id}', [UserController::class, 'update']);

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
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
