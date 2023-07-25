<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SalesController,
    AccountController,
    CostumerController,
    OrderController,
    MenuController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('item', [SalesController::class, 'inputdata']);
    
    Route::middleware(['level:admin'])->group(function () {
        Route::get('admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.adminhome');
        Route::resource('account', AccountController::class);
    });
    Route::middleware(['level:cashier'])->group(function () {
        Route::get('cashier', [App\Http\Controllers\HomeController::class, 'cashier'])->name('cashier.cashierhome');
        Route::resource('costumer', CostumerController::class);
        Route::resource('order', OrderController::class);
        Route::resource('menu', MenuController::class);
        Route::get('buy', [OrderController::class, 'ordering'])->name('order.buy');
        Route::get('/menu/{id}/statusUpdate', [MenuController::class, 'statusUpdate'])->name('menu.statusUpdate');
        Route::post('upload', [MenuController::class, 'upload'])->name('menu.upload');

        Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/increment', [OrderController::class, 'increment'])->name('cart.increment');
        Route::post('/cart/decrement', [OrderController::class, 'decrement'])->name('cart.decrement');
        Route::get('checkout', [OrderController::class, 'checkout'])->name('order.checkout');
        Route::get('/order/{id}/updateStatus', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
        Route::get('/order/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
    });
    // route::get('logout',[App\Http\Controllers\HomeController::class, 'logout'])->name('logout');


});