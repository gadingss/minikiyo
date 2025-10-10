<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderLocationController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\MidtransController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('beranda');
})->name('beranda');;

Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');


Route::get('/order', function () {
    return view('order');
})->name('order');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::get('/lokasi', [OrderLocationController::class, 'index'])->name('lokasi');


Route::post('/midtrans/callback', [MidtransController::class, 'callback']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('orders.riwayat');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/list', [CartController::class, 'list'])->name('cart.list');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

require __DIR__.'/auth.php';
