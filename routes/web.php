<?php

use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
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

Route::get('/', [PagesController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/home/data-keluarga', DataKeluargaController::class);
    Route::post('/home/data-keluarga/tambah-anggota-keluarga', [App\Http\Controllers\DataKeluargaController::class, 'tambahAnggotaKeluarga'])->name('tambah-anggota-keluarga');
    Route::put('/home/data-keluarga/edit-data-kk/{id}', [App\Http\Controllers\DataKeluargaController::class, 'editKK'])->name('editKK');
    Route::put('/home/data-keluarga/edit-anggota-keluarga/{id}', [App\Http\Controllers\DataKeluargaController::class, 'editAnggotaKeluarga'])->name('editAnggotaKeluarga');
    Route::resource('/home/data-user', UserController::class);

    Route::get('/get-kartu-keluarga/{osm_id}', [App\Http\Controllers\DataKeluargaController::class, 'getKartuKeluargaByOsmId']);

    Route::get('/tambah-data/{id}', [App\Http\Controllers\DataKeluargaController::class, 'create'])->name('tambah.data');
    Route::get('/lihat-data/{id}', [App\Http\Controllers\DataKeluargaController::class, 'show'])->name('lihat.data');

    Route::post('/upload-foto-rumah', [App\Http\Controllers\DataKeluargaController::class, 'upload'])->name('upload.foto_rumah');

    Route::get('/kartu-keluarga/export', [DataKeluargaController::class, 'export'])->name('laporan-kartu-keluarga.export');
});
