<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    $title = 'Home';
    $setting = Setting::getSetting();
    $produk = Produk::latest()->limit(4)->get();
    return view('pages.index', ['title' => $title, 'setting' => $setting, 'produk' => $produk]);
});
Route::get('/about', function () {
    $title = 'About';
    $setting = Setting::getSetting();
    return view('pages.about', ['title' => $title, 'setting' => $setting]);
});
Route::get('/semua-produk', function () {
    $title = 'Semua Produk';
    $setting = Setting::getSetting();
    return view('pages.semua-produk', ['title' => $title, 'setting' => $setting]);
});
Auth::routes(['verify' => true]);
Auth::routes();
Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //customers managemen
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
});
Route::middleware(['auth:web', 'role:Admin', 'verified'])->group(function () {
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::put('/setting/update', [SettingController::class, 'update'])->name('setting.update');
    //stok managemen
    Route::get('/stok', [StokController::class, 'index'])->name('stok');
    Route::post('/stok/store',  [StokController::class, 'store'])->name('stok.store');
    Route::get('/stok/edit/{id}',  [StokController::class, 'edit'])->name('stok.edit');
    Route::delete('/stok/delete/{id}',  [StokController::class, 'destroy'])->name('stok.delete');
    Route::get('/stok-datatable', [StokController::class, 'getStoksDataTable']);
    //produk managemen
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::post('/produk/store',  [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/edit/{id}',  [ProdukController::class, 'edit'])->name('produk.edit');
    Route::delete('/produk/delete/{id}',  [ProdukController::class, 'destroy'])->name('produk.delete');
    Route::get('/produk-datatable', [ProdukController::class, 'getProdukDataTable']);
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable', [UserController::class, 'getUsersDataTable']);
});
