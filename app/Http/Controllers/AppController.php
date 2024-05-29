<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /* Función que redirije al usuario al home o al login */
    public function index()
    {
        if (Auth::check()) {
            // Recoge los socios expulsados .-
            $oPrt = Partner::where([
                ['expulsado', true],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', false],
            ])->get();

            // Recoge los proximos eventos .-
            $evs = Event::where(['id']);
            // Recoge los socios nuevos a 15 dias .-
            // Recoge las nuevas incidencias en los ultimos 15 dias .-
            return redirect()->route('app.show');
        } else {
            return redirect()->route('login.index');
        }
    }

    public function show()
    {
        return view('index');
    }
}
