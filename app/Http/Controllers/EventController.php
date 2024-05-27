<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /* Función que devuelve la lista de eventos */
    public function index()
    {

        // Recoge todos los socios que tiene el centro .-
        $rmsIds = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get(['idSala']);
        $rms = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get();

        // Recoge todos los eventos que tiene el centro .-
        $evs = DB::table('V_RoomsEvents')->whereIn('idSala', $rmsIds)->paginate(25);

        // Se almacena todo en una variable .-
        $data = [
            'rooms' => $rms,
            'events' => $evs
        ];
        return view('events.list')->with('data', $data);
    }

    /* Función que redirige a la creación del evento */
    public function createIndex(){

        // Recoge todos los socios que tiene el centro .-
        $rmsIds = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get(['idSala']);
        $rms = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get();

        return view('events.create')->with('data', $rms);
    }
}
