<?php

use App\Http\Controllers\AnggotaKelasController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PeriodeKbmController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SettingSppController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['auth']], function () {
    Route::resource('dasbord', FrontController::class);

    //Periode
    Route::resource('periode', PeriodeKbmController::class);

    //AnggotaKelas
    Route::resource('anggotakelas', AnggotaKelasController::class);

    //SettingSpp
    Route::resource('settingspp', SettingSppController::class);

    Route::resource('petugas', PetugasController::class);

    Route::resource('spp', SppController::class);

    Route::resource('kelas', KelasController::class);

    Route::resource('siswa', SiswaController::class);
    Route::get('usersiswa', [SiswaController::class, 'userSiswa']);
    Route::get('datasiswa/{id}', [SiswaController::class, 'datasiswa']);
    //Import Siswa
    Route::post('importsiswa', [SiswaController::class, 'importsiswa']);

    Route::resource('pembayaran', PembayaranController::class);

    //new pembayaran
    Route::get('pembayaranbaru', [PembayaranController::class, 'pembayaranbaru']);
    Route::post('storebaru', [PembayaranController::class, 'storebaru']);
    Route::get('print/{id}', [PembayaranController::class, 'print']);

    //Cart Pembayaran
    Route::get('cart', [PembayaranController::class, 'cart']);
    Route::get('hapus/{id}', [PembayaranController::class, 'hapus']);
    Route::get('reset', [PembayaranController::class, 'reset']);
    Route::get('store', [PembayaranController::class, 'store']);

    //History
    Route::get('history', [PembayaranController::class, 'history']);
});

Route::get('/', [FrontController::class, 'login']);
Route::post('postlogin', [FrontController::class, 'postlogin']);
Route::get('logout', [FrontController::class, 'logout']);


// Route::get('hapus/{id_siswa}/{bulan_dibayar}/{tahun_dibayar}', [PembayaranController::class, 'hapus']);
