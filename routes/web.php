<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Models\Resource;
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

/* Rutas principales */

Route::controller(AppController::class)->group(function () {
    Route::get('/info', 'infoIndex')->name('app.info');
    Route::get('/home', 'index')->name('app.index');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'loginIndex')->name('login.index');
    Route::post('/login', 'verify')->name('login.verify');
});

Route::middleware(['authenticated'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('user.index');
            Route::get('/user/view/{id}', 'viewIndex')->name('user.view');
            Route::get('/user/create', 'createIndex')->name('user.create');
            Route::post('/users', 'filter')->name('user.filter');
            Route::post('/user/create', 'store')->name('user.store');
        });

        /* Rutas del admin */
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/partners', 'partnersIndex')->name('admin.partners.index');
            Route::put('/admin/partner/delete', 'deletePartnerInfo')->name('admin.partner.info.delete');
            Route::put('/user/delete', 'deleteCenterInfo')->name('admin.user.info.delete');
            Route::post('/admin/partners', 'partnersfilter')->name('admin.partners.filter');
        });
    });
    Route::middleware(['user'])->group(function () {
        Route::middleware(['partner'])->group(function () {
            /* Rutas para socios */
            Route::controller(PartnerController::class)->group(function () {
                Route::get('/partner/edit/{id}', 'editIndex')->name('partner.edit');
                Route::get('/partner/view/{id}', 'viewIndex')->name('partner.view');
                Route::post('/partner/disable/{id}', 'disable')->name('partner.disable');
                Route::put('/partner/update/{id}', 'update')->name('partner.update');
            });

            Route::post('/partner/view/{idSocio}', [IncidentController::class, 'filterFromPartner'])->name('incident.partner.filter');
        });
        Route::middleware(['room'])->group(function () {
            /* Rutas para salas */
            Route::controller(RoomController::class)->group(function () {
                Route::get('/room/edit/{id}', 'editIndex')->name('room.edit');
                Route::get('/room/view/{id}', 'viewIndex')->name('room.view');
                Route::put('/room/update/{id}', 'update')->name('room.update');
            });

            Route::post('/room/view/{idSala}', [ResourceController::class, 'filterFromRoom'])->name('resource.room.filter');
        });
        Route::middleware(['resource'])->group(function () {
            /* Rutas para recursos */
            Route::controller(ResourceController::class)->group(function () {
                Route::post('/resource/disable', 'disable')->name('resource.disable');
                Route::put('/resource/update', 'update')->name('resource.update');
            });
        });
        Route::middleware(['incident'])->group(function () {
            /* Rutas para incidencias */
            Route::controller(IncidentController::class)->group(function () {
                Route::get('/incident/edit/{id}', 'editIndex')->name('incident.edit');
                Route::get('/incident/view/{id}', 'viewIndex')->name('incident.view');
                Route::post('/incident/disable/{id}', 'disable')->name('incident.disable');
                Route::put('/incident/update/{id}', 'update')->name('incident.update');
            });
        });
        Route::middleware(['event'])->group(function () {
            /* Rutas para eventos */
            Route::controller(EventController::class)->group(function () {
                Route::get('/event/edit/{id}', 'editIndex')->name('event.edit');
                Route::get('/event/view/{id}', 'viewIndex')->name('event.view');
                Route::put('/event/disable/{id}', 'disable')->name('event.disable');
                Route::put('/event/udpate', 'update')->name('event.update');
            });
        });
        /* Rutas para socios */
        Route::controller(PartnerController::class)->group(function () {
            Route::get('/partners', 'index')->name('partner.index');
            Route::get('/partner/create', 'createIndex')->name('partner.create');
            Route::post('/partners', 'filter')->name('partner.filter');
            Route::post('/partner/create', 'store')->name('partner.store');
        });

        /* Rutas para salas */
        Route::controller(RoomController::class)->group(function () {
            Route::get('/rooms', 'index')->name('room.index');
            Route::get('/room/create', 'createIndex')->name('room.create');
            Route::post('/rooms', 'filter')->name('room.filter');
            Route::post('/room/create', 'store')->name('room.store');
        });

        /* Rutas para recursos */
        Route::controller(ResourceController::class)->group(function () {
            Route::get('/resources', 'index')->name('resource.index');
            Route::post('/resources/create', 'store')->name('resource.store');
            Route::post('/resources', 'filter')->name('resource.filter');
            Route::put('/resource/add', 'add')->name('resource.add');
            Route::put('/resource/storage', 'storage')->name('resource.storage');
        });

        /* Rutas para incidencias */
        Route::controller(IncidentController::class)->group(function () {
            Route::get('/incidents', 'index')->name('incident.index');
            Route::get('/incident/create', 'createIndex')->name('incident.create');
            Route::post('/incidents', 'filter')->name('incident.filter');
            Route::post('/incident/store', 'store')->name('incident.store');
        });

        /* Rutas para eventos */
        Route::controller(EventController::class)->group(function () {
            Route::get('/events', 'index')->name('event.index');
            Route::get('/event/create', 'createIndex')->name('event.create');
            Route::post('/event', 'filter')->name('event.filter');
            Route::post('/event/store', 'store')->name('event.store');
        });

        /* Rutas para las estadisticas */
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user/edit/{id}', 'editIndex')->name('user.edit');
        Route::get('/logout', 'logout')->name('user.logout');
        Route::put('/user/update', 'update')->name('user.update');
    });
});

Route::get('/', function () {
    return redirect()->route('app.index');
});

Route::fallback(function () {
    return redirect()->route('app.index');
});
