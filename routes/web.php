<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showSigninForm'])->name('signin');
    Route::post('/', [AuthController::class, 'handleSignin'])->name('signin.submit');
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'handleSignup'])->name('signup.submit');

    // Legacy routes
    Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'handleSignin'])->name('signin.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    //Pelanggan routes
    Route::post('/check-pelanggan', [PelangganController::class, 'checkPelanggan'])->name('check.pelanggan');

    //Barang routes
    Route::post('/check-barang', [BarangController::class, 'checkBarang'])->name('check.barang');

    // Invoice routes
    Route::get('/invoice/{id_transaksi}', [InvoiceController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/invoice/print/{id_transaksi}', [InvoiceController::class, 'printInvoice'])->name('invoice.print');
    Route::get('/invoice-template', [InvoiceController::class, 'showTemplate'])->name('invoice.template');

    // Transaksi routes
    Route::get('/laporan/cetak', [TransaksiController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::get('/form', [TransaksiController::class, 'form'])->name('form');
    Route::post('/store', [TransaksiController::class, 'store'])->name('penjualan.store');
    Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan');

    // API routes
    Route::get('/get-pelanggan', [ApiController::class, 'getPelanggan'])->name('get.pelanggan');
    Route::get('/get-barang', [ApiController::class, 'getBarang'])->name('get.barang');
    Route::get('/get-stock-barang', [ApiController::class, 'getStockBarang'])->name('get.stock.barang');

    // ActionController routes (existing)
    Route::get('/barang', [ActionController::class, 'barang'])->name('barang');
    Route::get('/barang/add', [ActionController::class, 'createBarang'])->name('createBarang');
    Route::post('/barang/store', [ActionController::class, 'storeBarang'])->name('storeBarang');
    Route::get('/barang/edit/{id_barang}', [ActionController::class, 'editbarang'])->name('editbarang');
    Route::put('/barang/update/{id_barang}', [ActionController::class, 'updatebarang'])->name('updatebarang');
    Route::delete('/barang/delete/{id_barang}', [ActionController::class, 'deletebarang'])->name('delete_barang');

    Route::get('/pelanggan', [ActionController::class, 'pelanggan'])->name('pelanggan');
    Route::get('/pelanggan/add', [ActionController::class, 'createpelanggan'])->name('createpelanggan');
    Route::post('/pelanggan/store', [ActionController::class, 'storepelanggan'])->name('storepelanggan');
    Route::get('/pelanggan/edit/{id_pelanggan}', [ActionController::class, 'editpelanggan'])->name('editpelanggan');
    Route::put('/pelanggan/update/{id_pelanggan}', [ActionController::class, 'updatepelanggan'])->name('updatepelanggan');
    Route::delete('/pelanggan/delete/{id_pelanggan}', [ActionController::class, 'deletepelanggan'])->name('delete_pelanggan');

    Route::get('/user', [ActionController::class, 'user'])->name('user');
    Route::get('/user/add', [ActionController::class, 'createUser'])->name('add_user');
    Route::post('/user/store', [ActionController::class, 'storeUser'])->name('store_user');
    Route::get('/user/edit/{username}', [ActionController::class, 'editUser'])->name('action.edit_user');
    Route::post('/user/update/{username}', [ActionController::class, 'updateUser'])->name('update_user');
    Route::delete('/user/delete/{username}', [ActionController::class, 'deleteUser'])->name('delete_user');
});

// Fallback route for 404
Route::fallback(function () {
    return view('errors.404');
});
