<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ClubBookingController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/gmail', [AuthController::class, 'gmail']);
Route::post('/login', [AuthController::class, 'login']);



// products
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [HomeController::class, 'products']);
    Route::get('/category', [HomeController::class, 'categories']);
    Route::get('/{id}', [HomeController::class, 'product']);
});


Route::post('check/webhook', [HomeController::class, 'check']);


// ========================= routes auth driver ========================================
Route::middleware('auth:sanctum')->group(function () {

    // auth user
    Route::group(['prefix' => 'user'], function () {
        Route::post('/update-profile', [AuthController::class, 'update_profile']);
        Route::get('/get-profile', [AuthController::class, 'get_profile']);
        Route::get('/delete-profile', [AuthController::class, 'delete_profile']);
        Route::post('/change-password', [AuthController::class, 'change_Password']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });


    // address
    Route::post('address', [HomeController::class, 'add_address']);
    Route::get('address', [HomeController::class, 'get_addresses']);
    Route::post('orders', [HomeController::class, 'store_order']);
    Route::post('orders', [HomeController::class, 'store_order']);
    Route::put('/orders/{id}/status', [HomeController::class, 'updateStatus']);

    // carts
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/update_quantity', [CartController::class, 'update_cart_quantity']);
    Route::get('/carts', [CartController::class, 'cart']);
    Route::delete('/carts/{id}', [CartController::class, 'delete_cart']);
    Route::delete('/carts', [CartController::class, 'delete_all_carts']);


});
