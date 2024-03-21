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
    Route::resource('/home/data-user', UserController::class);

    Route::get('/get-kartu-keluarga/{osm_id}', [App\Http\Controllers\DataKeluargaController::class, 'getKartuKeluargaByOsmId']);
});
