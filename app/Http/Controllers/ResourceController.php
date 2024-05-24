<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /* Función que realiza la inserción de un recurso */
    public function store(Request $req, $idSala)
    {
        // Realiza la validación de los datos .-
        $this->validateOthers($req);

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

    /* Función que envia a la vista de la sala con la lista de recursos filtrada */
    public function filter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('id') && !$req->filled('nombre')) {
            return redirect()->route('room.view', $req->idSala);
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

                // Recoge los recursos de la sala .-
                $query->where('idSala', $req->idSala);

                $objs = $query->paginate(25);

                // Recoge la información de la sala .-
                $room = new RoomController();
                $room = $room->getRoomInfo($req->idSala);

                // Añadimos toda la información en una variable .-  
                $data = [
                    'room' => $room,
                    'resources' => $objs
                ];

                return view('rooms.view')->with('data', $data);
            } catch (Exception $err) {
                return redirect()->route('app.show')->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Metodo que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'nombre' => 'required|max:30',
        ]);
    }

    /* Metodo que deshabilita el recurso */
    public function disable(Request $req)
    {
        Resource::where('idRecurso', $req->idRecurso)->update(['deshabilitado' => true]);
        return redirect()->back()->with('info', ['message' => 'Recurso eliminado con exito!']);
    }
}
