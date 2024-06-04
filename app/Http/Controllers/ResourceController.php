<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{

    /* Función que redirige a la lista de recursos */
    public function index()
    {

        // Recoge todas las salas que tiene el centro .-
        $ids = Room::where('idUsuario', Auth::user()->id)->get(['idSala']);
        $rooms = Room::where('idUsuario', Auth::user()->id)->get(['idSala', 'nombre']);

        // Recoge todos los recursos que tienen la salas .-
        $objs = Resource::whereIn('idSala', $ids)->where('deshabilitado', false)->paginate(25);


        // Se almacena los datos de la sala .-
        $data = [
            'resources' => $objs,
            'rooms' => $rooms
        ];
        return view('resources.list')->with('data', $data);
    }

    /* Función que realiza la inserción de un recurso */
    public function store(Request $req, $idSala = null)
    {
        $rm = new RoomController();

        // Realiza la validación de los datos .-
        $this->validateOthers($req);

        // En caso de que el idSala sea nulo, asigna el id del Almacen .-
        if (!$idSala) {
            $idSala = $rm->getStorageId()[0]['idSala'];
        }

        // Se almacena los datos de la sala .-
        $data = [
            'idSala' => $idSala,
            'nombre' => $req->nombre,
            'tipo' => $req->tipo
        ];

        // Se realiza la inserción de los datos .-
        try {
            Resource::create($data);
            return redirect()->back()->with('info', ['message' => 'Recurso creado con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que realiza la inserción de un recurso */
    public function update(Request $req)
    {
        // Realiza la validación de los datos .-
        $this->validateOthers($req);
        // Se almacena los datos de la sala .-
        $data = [
            'idSala' => $req->sala,
            'nombre' => $req->nombre,
            'tipo' => $req->tipo
        ];

        // Se realiza la inserción de los datos .-
        try {
            Resource::where('idRecurso', $req->idRecurso)->update($data);
            return redirect()->back()->with('info', ['message' => 'Recurso actualizado con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que añadira el recurso a una sala */
    public function add(Request $req)
    {
        Resource::where('idRecurso', $req->recurso)->update(['idSala' => $req->idSala]);
        return redirect()->back()->with('info', ['message' => 'Recurso añadido con exito!']);
    }

    /* Función que añadira el recurso a una sala */
    public function storage(Request $req)
    {
        $rm = new RoomController();
        Resource::where('idRecurso', $req->idRecurso)->update(['idSala' => $rm->getStorageId()[0]['idSala']]);
        return redirect()->back()->with('info', ['message' => 'Recurso añadido con exito!']);
    }

    /* Función que envia a la vista de la sala con la lista de recursos filtrada */
    public function filter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('id') && !$req->filled('nombre') && $req->tipo == '-') {
            return redirect()->route('resource.index');
        } else {
            try {
                $query = Resource::query();

                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('id')) {
                    $query->where('idRecurso', $req->id);
                }

                if ($req->filled('nombre')) {
                    $query->where('nombre', 'like', '%' . $req->nombre . '%');
                }

                if ($req->tipo != '-') {
                    $query->where('tipo', $req->tipo);
                }

                // Recoge todas las salas del centro .-
                $ids = Room::where('idUsuario', Auth::user()->id)->get(['idSala']);
                $rooms = Room::where('idUsuario', Auth::user()->id)->get(['idSala', 'nombre']);

                // Recoge los recursos de todas las salas que tiene el centro .-
                $query->whereIn('idSala', $ids)->where('deshabilitado', false);
                $objs = $query->paginate(25);

                $data = [
                    'resources' => $objs,
                    'rooms' => $rooms
                ];

                return view('resources.list')->with('data', $data);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que envia a la vista de la sala con la lista de recursos filtrada */
    public function filterFromRoom(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('id') && !$req->filled('nombre') && $req->tipo == '-') {
            return redirect()->route('room.view', $req->idSala);
        } else {
            try {
                $rm = new RoomController();
                $query = Resource::query();

                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('id')) {
                    $query->where('idRecurso', $req->id);
                }

                if ($req->filled('nombre')) {
                    $query->where('nombre', 'like', '%' . $req->nombre . '%');
                }

                if ($req->tipo != '-') {
                    $query->where('tipo', $req->tipo);
                }

                // Recoge los recursos de la sala .-
                $query->where([
                    ['idSala', $req->idSala],
                    ['deshabilitado', false]
                ]);

                $rmResources = $query->paginate(25);

                // Recoge todas salas del centro .-
                $rms = Room::where('idUsuario', Auth::user()->id)->get(['idSala']);

                // Recoge todos los recursos del centro .-
                $resources = Resource::whereIn('idSala', $rms)->where([
                    ['idSala','!=', $req->idSala],
                    ['deshabilitado', false]
                ]);

                // Añadimos toda la información en una variable .-  
                $data = [
                    'room' => $rm->getRoomInfo($req->idSala),
                    'resources' => $resources,
                    'rmResources' => $rmResources,
                    'storage' => $rm->isStorage($req->idSala)
                ];

                return view('rooms.view')->with('data', $data);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Metodo que deshabilita el recurso */
    public function disable(Request $req)
    {
        Resource::where('idRecurso', $req->id)->update(['deshabilitado' => true]);
        return redirect()->back()->with('info', ['message' => 'Recurso eliminado con exito!']);
    }

    /* Metodo que devuelve el recurso al almacen */
    public function disableFromRoom(Request $req)
    {
        Resource::where('idRecurso', $req->id)->update(['deshabilitado' => true]);
        return redirect()->back()->with('info', ['message' => 'Recurso movido al almacen con exito!']);
    }

    /* Metodo que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'nombre' => 'required|max:30',
        ]);
    }
}
