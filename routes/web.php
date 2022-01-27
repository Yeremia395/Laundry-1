<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which-
| Author : Yeremia Rizky
| -is assigned the "api" middleware group. Enjoy building your API!
|
*/
    // dashboard
    Route::get('/dashboard', function () {
    return view('index');
});    
    //USER
    Route::post('user/tambah', [UserController::class, 'register']);  
    Route::post('login', [UserController::class, 'login']);
    
    //LOGIN CHECK (ADMIN&KASIR)
    Route::group(['middleware' => ['jwt.verify:admin,kasir']], function() {

    Route::post('login/check', [UserController::class, 'loginCheck']);
    Route::get('user/tampil', [UserController::class, 'getUser']);
    Route::post('logout', [UserController::class, 'logout']);
});
    //OUTLET(ADMIN&KASIR)
    Route::group(['middleware' => ['jwt.verify:admin,kasir']], function() {

    Route::post('outlet/tambah', [OutletController::class, 'store']);
    Route::get('outlet/tampil', [OutletController::class, 'getAll']);
    Route::get('outlet/tampilID/{id}', [OutletController::class, 'getById']);
    Route::put('outlet/updateID/{id}', [OutletController::class, 'update']);
    Route::delete('outlet/hapusID/{id}', [OutletController::class, 'delete']);
 });
    //MEMBER(ADMIN&KASIR)
    Route::group(['middleware' => ['jwt.verify:admin,kasir']], function() {
    
    Route::post('member/tambah', [MemberController::class, 'store']);
    Route::get('member/tampil', [MemberController::class, 'getAll']);
    Route::get('member/tampilID/{id}', [MemberController::class, 'getById']);
    Route::put('member/updateID/{id}', [MemberController::class, 'update']);
    Route::delete('member/hapusID/{id}', [MemberController::class, 'delete']);
  });
    //PAKET(ADMIN&KASIR) 
    Route::group(['middleware' => ['jwt.verify:admin,kasir']], function() {

    Route::post('paket/tambah', [PaketController::class, 'store']);
    Route::get('paket/tampil', [PaketController::class, 'getAll']);
    Route::get('paket/tampilID/{id}', [PaketController::class, 'getById']);
    Route::put('paket/updateID/{id}', [PaketController::class, 'update']);
    Route::delete('paket/hapusID/{id}', [PaketController::class, 'delete']);
});
    //TRANSAKSI(ADMIN&KASIR)
    Route::group(['middleware' => ['jwt.verify:admin,kasir']], function() {

    Route::post('transaksi/tambah', [TransaksiController::class, 'store']);
    Route::get('transaksi/tampil', [TransaksiController::class, 'getAll']);
    Route::get('transaksi/tampilID/{id}', [TransaksiController::class, 'getById']);

    //MASIH ERROR GATAU KENAPA
    Route::post('transaksi/detail/tambah', [DetailTransaksiController::class, 'store']);
    Route::get('transaksi/detail/tampilID{id}', [DetailTransaksiController::class, 'getById']);
    Route::post('transaksi/statusID/{id}', [TransaksiController::class, 'changeStatus']);
    Route::post('transaksi/bayarID/{id}', [TransaksiController::class, 'bayar']);
    Route::get('transaksi/totalID/{id}', [DetailTransaksiController::class, 'getTotal']);
});

/*
|--------------------------------------------------------------------------
| @yeremiarizky_
|--------------------------------------------------------------------------
*/

//Route::get('/', function () {
    //return view('welcome')
