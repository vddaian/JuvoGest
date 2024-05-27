<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Exception;
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
        $evs = DB::table('V_RoomsEvents')->whereIn('idSala', $rmsIds)->where('deshabilitado', false)->paginate(25);
        
        
        // Se almacena todo en una variable .-
        $data = [
            'rooms' => $rms,
            'events' => $evs
        ];
        return view('events.list')->with('data', $data);
    }

    /* Función que redirige a la creación del evento */
    public function createIndex()
    {

        // Recoge todos los socios que tiene el centro .-
        $rmsIds = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get(['idSala']);
        $rms = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get();

        return view('events.create')->with('data', $rms);
    }

    /* Función que redirige a la edición del evento */
    public function editIndex($id)
    {

        // Recoge todos los socios que tiene el centro .-
        $rmsIds = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get(['idSala']);
        $rms = Room::where([['idUsuario', Auth::user()->id], ['deshabilitado', false]])->get();

        // Recoge la información del evento .-
        $ev = $this->getEventInfo($id);

        // Se almacena toda la información en un lugar .-
        $data = [
            'rooms' => $rms,
            'event' => $ev
        ];
        return view('events.edit')->with('data', $data);

    }

    /* Función que almacena la información del evento en la bbdd */
    public function store(Request $req)
    {
        if (
            $this->checkNumeric($req->asistentes)
        ) {
            // Verifica los campos .-
            $this->validateOthers($req);

            // Se almacena todo en una variable .-
            $data = [
                'idSala' => $req->sala,
                'titulo' => $req->titulo,
                'entidadOrg' => $req->entidad,
                'numeroAsistentes' => $req->asistentes,
                'fechaEvento' => $req->fecha,
                'horaEvento' => $req->hora,
                'informacion' => $req->info
            ];
            try {
                Event::create($data);
                return redirect()->back()->with('info', ['message' => 'Evento creado con exito!']);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        } else {
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'Hay campos mal!'
            ]);
        }
    }

    /* Función que actualiza el registro */
    public function update(Request $req)
    {
        if (
            $this->checkNumeric($req->asistentes)
        ) {
            // Verifica los campos .-
            $this->validateOthers($req);

            // Se almacena todo en una variable .-
            $data = [
                'idSala' => $req->sala,
                'titulo' => $req->titulo,
                'entidadOrg' => $req->entidad,
                'numeroAsistentes' => $req->asistentes,
                'fechaEvento' => $req->fecha,
                'horaEvento' => $req->hora,
                'informacion' => $req->info
            ];
            try {
                Event::where('idEvento', $req->idEvento)->update($data);
                return redirect()->back()->with('info', ['message' => 'Evento actualizado con exito!']);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        } else {
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'Hay campos mal!'
            ]);
        }
    }


    /* Funcion que deshabilita un evento */
    public function disable($id){
        try {
            Event::where('idEvento', $id)->update(['deshabilitado' => true]);
            return redirect()->back()->with('info', ['message' => 'Evento eliminado con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que recoge toda la información del evento */
    public function getEventInfo($id){
        return Event::where('idEvento',$id )->get();
    }

    /* Metodo que valida los campos que no sean numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'titulo' => 'required|max:30',
            'entidad' => 'required|max:30',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);
    }

    /* Función que valida los campos numericos */
    public function checkNumeric($asistentes)
    {
        $val = true;

        if ($asistentes) {
            if (is_numeric($asistentes)) {
                if (strlen($asistentes) > 7) {
                    $val = false;
                }
            } else {
                $val = false;
            }
        }

        return $val;
    }
}
