<?php
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryProductController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\LoginController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/storage'; // Added a slash (/)

    if (!file_exists($linkFolder)) {
        symlink($targetFolder, $linkFolder);
        return 'Symlink created successfully.';
    } else {
        return 'Symlink already exists.';
    }
});

Route::get('/opt', function () {
    Artisan::call('optimize');
    return 1;
});


Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');


Route::middleware('localization')->group(function () {
    Route::group(['prefix' => 'cart', 'as' => 'cart.', 'middleware' => ['auth']], function () {
        Route::controller(CartController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('add-to-cart', 'store')->name('addToCart');
            Route::post('/{id}/destroy', 'destroy')->name('destroy');
            Route::post('order-store', 'storeOrder')->name('order.store');

        });
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('register', [LoginController::class, 'register'])->name("register");
        Route::post('store', [LoginController::class, 'store'])->name("store");
        Route::get('login', [LoginController::class, 'create'])->name("login");
        Route::post('login', [LoginController::class, 'login'])->name("auth.login");
        Route::get('logout', [LoginController::class, 'logout'])->name("logout");
    });

    Route::controller(IndexController::class)->group(function () {
        Route::get('cart-count/', 'getCartCount')->name('cart.count');
        Route::get('/', 'index')->name('home');
        Route::prefix('website')->name('website.')->group(function () {
            Route::get('/', 'index')->name('products.index');
            Route::get('/products/{product}', 'show')->name('products.show');
            Route::get('/category/{id}', 'filter_category')->name('categories.show');
            Route::post('products/{id}/get-price',  'getPrice')->name('products.get.price');
        });
    });






///////////////////////////  dashboard admin   ///////////////////////////////////////////////////////////

    Route::get('login', [AuthController::class, 'create'])->name("login");
    Route::post('login', [AuthController::class, 'login'])->name("admin.login");
    Route::get('logout', [AuthController::class, 'logout'])->name("logout");
    Route::middleware([ "admin"])->group(function () {

        Route::get('/dashboard',[HomeController::class,'dashboard'])->name("dashboard.index");

        Route::resource("users", UserController::class);
        Route::post('/users/deleteSelected', [UserController::class,'deleteSelected'])->name('users.deleteSelected');
        Route::post('toggle-activation/users', [UserController::class, 'toggleActivation'])->name('users.toggleActivation');

        Route::resource("admins", AdminController::class);
        Route::post('/admins/deleteSelected', [AdminController::class,'deleteSelected'])->name('admins.deleteSelected');
        Route::post('toggle-activation/admins', [AdminController::class, 'toggleActivation'])->name('admins.toggleActivation');

        Route::resource("category_products", CategoryProductController::class);
        Route::post('/category_products/deleteSelected', [CategoryProductController::class,'deleteSelected'])->name('category_products.deleteSelected');

        Route::resource("products", ProductController::class);
        Route::post('dropzone',[ProductController::class, 'dropzone'])->name('dropzone.files');
        Route::post('/products/deleteSelected', [ProductController::class,'deleteSelected'])->name('products.deleteSelected');
        Route::post('toggle-activation/products', [ProductController::class, 'toggleActivation'])->name('products.toggleActivation');

        Route::get('/offers/products', [OfferController::class,'offer_on_product'])->name('offers.products');
        Route::resource("offers", OfferController::class);
        Route::post('/offers/deleteSelected', [OfferController::class,'deleteSelected'])->name('offers.deleteSelected');
        Route::post('/offers/products', [OfferController::class,'store_offer_on_product'])->name('offers.products.store');
        Route::post('toggle-activation/offers', [OfferController::class, 'toggleActivation'])->name('products.toggleActivation');


        Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
        Route::get('/orders/order_admins', [OrderController::class, 'order_admins'])->name('orders.order_admins');
        Route::get('/orders/{id}', [OrderController::class,'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::put('/orders/{id}/paid', [OrderController::class, 'order_paid'])->name('orders.paid');
        Route::put('/items/{id}/status', [OrderController::class, 'updateItemStatus'])->name('orders.items.status');

        Route::resource("payment", PaymentController::class);

        Route::resource("settings", SettingController::class);

    });

});
