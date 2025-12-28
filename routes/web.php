<?php

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

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\OrderController as FrontOrderController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produit/{slug}', [FrontProductController::class, 'show'])->name('front.product.show');
Route::post('/commande', [FrontOrderController::class, 'store'])->name('front.order.store');
Route::get('/commande/merci/{order}', [FrontOrderController::class, 'thankYou'])->name('front.thankyou');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect /admin to /admin/login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Auth
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
