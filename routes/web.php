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


// Route::get('/', function () {
//     return view('welcome');
// });

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

Route::get('/test-supabase', function () {
    $filePath = storage_path('app/public/products/dimsum_goreng.jpg'); 
    $filename = time() . '_dimsum_goreng.jpg';

    if (!file_exists($filePath)) {
        return ['error' => 'File tidak ditemukan di path: ' . $filePath];
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_KEY'),
        'apikey' => env('SUPABASE_SERVICE_KEY'),
    ])->attach(
        'file', fopen($filePath, 'r'), $filename
    )->post(env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_BUCKET') . '/' . $filename);


    return [
        'status' => $response->status(),
        'body' => $response->body(),
    ];
});



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

Route::post('/save-location', function (Illuminate\Http\Request $r) {
    session(['user_address' => $r->address]);
    return response()->json(['success' => true]);
})->name('save.location');


Route::post('/reverse-geocode', function (\Illuminate\Http\Request $req) {

    $lat = $req->lat;
    $lon = $req->lon;

    $response = Http::withHeaders([
        'User-Agent' => 'MinikiyoApp/1.0 (admin@minikiyo.com)',
    ])->get('https://nominatim.openstreetmap.org/reverse', [
        'format' => 'json',
        'lat' => $lat,
        'lon' => $lon,
    ]);

    return $response->json();
});


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
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/html', [CartController::class, 'getCartHtml'])->name('cart.html');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/apply-promo', [CartController::class, 'applyPromoCode'])->name('cart.apply-promo');
    Route::post('/cart/remove-promo', [CartController::class, 'removePromoCode'])->name('cart.remove-promo');
    Route::post('/cart/update-delivery', [CartController::class, 'updateDeliveryOption'])->name('cart.update-delivery');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');






});

require __DIR__.'/auth.php';
