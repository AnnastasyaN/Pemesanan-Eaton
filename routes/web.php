<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Autentikasi Laravel
Auth::routes();

// Redirect setelah login berdasarkan role
Route::get('/home', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('menus.index'); // admin -> halaman manajemen menu
    } else {
        return redirect()->route('menu.index'); // user -> halaman daftar menu
    }
})->middleware('auth')->name('home');

// Route admin: CRUD menu
Route::middleware(['auth'])->group(function () {
    Route::resource('menus', MenuController::class); // khusus admin
});

// Route user: daftar menu makanan
Route::resource('menu', MenuViewController::class)->only(['index', 'show']); // user lihat menu

// Route keranjang (cart)
Route::middleware(['auth'])->prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('cart.index');
    Route::post('/', 'store')->name('cart.store');
    Route::put('/{id}', 'update')->name('cart.update');
    Route::delete('/{id}', 'remove')->name('cart.remove');
    Route::delete('/', 'clear')->name('cart.clear');
});

// Route checkout
Route::middleware(['auth'])->prefix('checkout')->controller(CheckoutController::class)->group(function () {
    Route::get('/', 'form')->name('checkout.form');
    Route::post('/', 'process')->name('checkout.process');
    Route::get('/success', 'success')->name('checkout.success');
    Route::get('/cetak-pdf', 'cetakPDF')->name('checkout.cetak');
});

// Custom login (override bawaan Laravel jika diperlukan)
Route::post('/login', [LoginController::class, 'login']);

Route::get('/menus/riwayat-transaksi', [App\Http\Controllers\Admin\RiwayatTransaksiController::class, 'index'])->name('admin.riwayat');
