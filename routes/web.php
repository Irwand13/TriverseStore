<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Route;

// Halaman utama: landing hero + produk unggulan.
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index']);

// Market: katalog lengkap dengan cari, filter, dan urutkan.
Route::get('/market', [ProductController::class, 'market'])->name('market');

// Tentang kami.
Route::view('/tentang', 'tentang')->name('tentang');

// Top up game (demo, tanpa payment gateway).
Route::get('/topup', [TopUpController::class, 'create'])->name('topup.create');
Route::post('/topup', [TopUpController::class, 'store'])->name('topup.store');
Route::get('/topup/{id}', [TopUpController::class, 'show'])->name('topup.show');

// Akun: hanya untuk user yang sudah login.
Route::get('/akun', [AccountController::class, 'show'])->name('akun')->middleware('auth');

// Auth hand-rolled: daftar, masuk, keluar.
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute CRUD produk. Polanya sama seperti contoh route di PPT
// (Route::get menerima request, mengembalikan response),
// hanya saja tiap rute diteruskan ke method Controller.
// Tulis/ubah/hapus hanya untuk user login; tamu diarahkan
// ke /login oleh middleware auth.
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');
