<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PengantaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\User;
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
Route::get('/pesanan', function () {
    $title = 'Pesanan Saya';
    $user = User::find(Auth::id());
    $setting = Setting::getSetting();
    $pesanan = Pesanan::with(['produk', 'user'])->where('id_user', Auth::id())->paginate(3);
    return view('pages.pesanan', ['title' => $title, 'user' => $user, 'setting' => $setting, 'pesanan' => $pesanan]);
});
Route::get('/my-akun', function () {
    $title = 'Akun Saya';
    $user = User::find(Auth::id());
    $setting = Setting::getSetting();
    return view('pages.akun', ['title' => $title, 'user' => $user, 'setting' => $setting]);
});
Route::get('/about', function () {
    $title = 'About';
    $setting = Setting::getSetting();
    return view('pages.about', ['title' => $title, 'setting' => $setting]);
});
Route::get('/semua-produk', function () {
    $title = 'Semua Produk';
    $setting = Setting::getSetting();
    $produk = Produk::latest()->get();
    return view('pages.semua-produk', ['title' => $title, 'setting' => $setting, 'produk' => $produk]);
});
Route::get('/detail-produk/{id}', function ($id) {
    $produk = Produk::find($id);
    $title = 'Produk : ' . $produk->nama_produk;
    $setting = Setting::getSetting();
    return view('pages.detail-produk', ['title' => $title, 'setting' => $setting, 'produk' => $produk]);
});
Auth::routes(['verify' => true]);
Auth::routes();
Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //buat pesanan
    Route::post('/pesanan/store',  [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/dibatalkan/{id}',  [PesananController::class, 'dibatalkan'])->name('pesanan.dibatalkan');
    Route::get('/pesanan/edit/{id}',  [PesananController::class, 'edit'])->name('pesanan.edit');
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
    //pesanan managemen
    Route::get('/pemesanan', [PesananController::class, 'index'])->name('pemesanan');
    Route::get('/pesanan-datatable', [PesananController::class, 'getPesananDataTable']);
    //return managemen
    Route::get('/return', [ReturnController::class, 'index'])->name('return');
    Route::get('/return-datatable', [ReturnController::class, 'getReturnDataTable']);
    //pengantaran managemen
    Route::post('/pengantaran/store',  [PengantaranController::class, 'store'])->name('pengantaran.store');
    Route::get('/pengantaran/pesanan/{id}',  [PengantaranController::class, 'pesanan'])->name('pengantaran.pesanan');
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
