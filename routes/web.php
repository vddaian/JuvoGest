<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoomController;
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

/* Rutas del socio */
Route::controller(PartnerController::class)->group(function () {
    Route::get('/partners', 'index')->name('partner.index');
    Route::get('/partner/create','createIndex')->name('partner.create');
    Route::get('/partner/edit/{id}', 'editIndex')->name('partner.edit');
    Route::get('/partner/view/{id}', 'viewIndex')->name('partner.view');
    Route::post('/partners', 'filter')->name('partner.filter');
    Route::post('/partner/create', 'store')->name('partner.store');
    Route::post('/partner/disable/{id}', 'disable')->name('partner.disable');
    Route::put('/partner/update/{id}', 'update')->name('partner.update');
});

/* Rutas de la sala */
Route::controller(RoomController::class)->group(function () { // Estado, Tipo [ P = 15, M =50 , G = 120, MG = 250]
    Route::get('/rooms', 'index')->name('room.index');
    Route::get('/room/create', 'createIndex')->name('room.create');
    Route::get('/room/edit/{id}', 'editIndex')->name('room.edit');
    Route::get('/room/view/{id}', 'viewIndex')->name('room.view');
    Route::post('/rooms', 'filter')->name('room.filter');
    Route::post('/room/create', 'store')->name('room.store');
    Route::post('/room/disable/{id}', 'disable')->name('room.disable'); // No se pueden borrar las salas solo cuando das de bara el centro.
    Route::put('/room/update/{id}', 'update')->name('room.update');
});

/* Rutas del recurso */
Route::controller(ResourceController::class)->group(function () {
    Route::get('/resources', 'index')->name('resource.index');
    Route::post('/resources/create', 'store')->name('resource.store');
    Route::post('/resources', 'filter')->name('resource.filter');
    Route::post('/room/view/{idSala}', 'filterFromRoom')->name('resource.room.filter');
    Route::post('/resource/disable', 'disable')->name('resource.disable');
    Route::put('/resource/update', 'update')->name('resource.update');
    Route::put('/resource/add', 'add')->name('resource.add');
    Route::put('/resource/storage', 'storage')->name('resource.storage');
});

/* Rutas principales */
Route::controller(AppController::class)->group(function () {
    Route::get('/home', 'show')->name('app.show');
    Route::get('/', 'index')->name('app.index');
});
