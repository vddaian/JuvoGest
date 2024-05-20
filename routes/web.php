<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\PartnerController;
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

/* Rutas de inicio, registro, desconexion y vista del usuario  */
Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'verify')->name('login.verify');
    Route::get('/login', 'loginIndex')->name('login.index');
    Route::post('/register', 'store')->name('register.store');
    Route::get('/register', 'registerIndex')->name('register.index');
    Route::get('/logout', 'logout')->name('user.logout');
});

Route::controller(PartnerController::class)->group(function () {
    Route::get('/partners', 'index')->name('partner.index');
    Route::post('/partners', 'filter')->name('partner.filter');
    Route::get('/partner/create','createIndex')->name('partner.create.index');
    Route::post('/partner/create', 'store')->name('partner.store');
});

/* Rutas principales */
Route::controller(AppController::class)->group(function () {
    Route::get('/home', 'show')->name('app.show');
    Route::get('/', 'index')->name('app.index');
});
