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
        Route::get('buy', [OrderController::class, 'buy'])->name('order.buy');
        Route::get('/menu/{id}/statusUpdate', [MenuController::class, 'statusUpdate'])->name('menu.statusUpdate');
        Route::post('upload', [MenuController::class, 'upload'])->name('menu.upload');
    });
    // route::get('logout',[App\Http\Controllers\HomeController::class, 'logout'])->name('logout');


});