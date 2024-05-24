<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Partner;
use App\Models\PartnerUser;

class RoomController extends Controller
{
    /* Función que devuelve la lista de salas */
    public function index()
    {
        try {

            // Recoge todas las salas que pertenezcan al centro .-
            $objs = Room::where([
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', false]
            ])->paginate(25);

            return view('rooms.list')->with('data', $objs);
        } catch (Exception $err) {
            return redirect()->route('app.show')->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que envia a la lista de salas filtrada */
    public function filter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('id') && !$req->filled('nombre')) {
            return redirect()->route('room.index');
        } else {
            try {
                $query = Room::query();

                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('id')) {
                    $query->where('idSocio', $req->id);
                }

                if ($req->filled('nombre')) {
                    $query->where('nombre', 'like', '%' . $req->nombre . '%');
                }

                // Recoge las salas del centro .-
                $query->where('idUsuario', Auth::user()->id);

                $objs = $query->paginate(25);
                return view('rooms.list')->with('data', $objs);
            } catch (Exception $err) {
                return redirect()->route('app.show')->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que devuelve el formulario para crear una sala */
    public function createIndex()
    {
        return view('rooms.create');
    }

    /* Función que devuelve la página de edición de la sala */
    public function editIndex($id)
    {
        return view('rooms.edit')->with('data', $this->getRoomInfo($id));
    }

    /* Función que devuelve la página de visualización de la sala */
    public function viewIndex($idSala)
    {
        // Recoge todas las salas del centro .-
        $ids = Room::where('idUsuario', Auth::user()->id)->get(['idSala']);

        // Recoge toda la información de recursos que tiene la sala .-
        $resources = Resource::where([
            ['idSala', $idSala],
            ['deshabilitado', false]
        ])->paginate(25);

        // Añadimos toda la información en una variable        
        $data = [
            'room' => $this->getRoomInfo($idSala),
            'resources' => $resources,
            'storage' => $this->isStorage($idSala)
        ];

        return view('rooms.view')->with('data', $data);
    }

    /* Función que crea una nueva sala */
    public function store(Request $req)
    {
        // Realiza la validación de los datos .-
        $this->validateOthers($req);

        // Se almacena los datos de la sala .-
        $data = [
            'idUsuario' => Auth::user()->id,
            'nombre' => $req->nombre,
            'informacion' => $req->info
        ];

        // Se realiza la inserción de los datos .-
        try {
            Room::create($data);
            return redirect()->back()->with('info', ['message' => 'Sala creada con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que realiza la actualización de la sala */
    public function update(Request $req)
    {

        // Realiza la validación de los datos .-
        $this->validateOthers($req);

        // Se almacena los datos de la sala .-
        $data = [
            'nombre' => $req->nombre,
            'informacion' => $req->info
        ];

        // Se realiza la inserción de los datos .-
        try {
            Room::where('idSala', $req->id)->update($data);
            return redirect()->back()->with('info', ['message' => 'Sala actualizada con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que deshabilita la sala */
    public function disable(Request $req)
    {
        // Comprueba si hay alguna relación de la sala con algun recurso .-
        if ($this->resourceRelationExists($req->id)) {
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'La sala no se ha podido eliminar, !'
            ]);
        } else {
            Room::where('idSala', $req->id)->update(['deshabilitado' => true]);
            return redirect()->back()->with('info', ['message' => 'Sala eliminada con exito!']);
        }
    }

    /* Función que devuelve toda la información de la sala */
    public function getRoomInfo($id)
    {
        return Room::where('idSala', $id)->get();
    }

     /* Función que devuelve el id del alamacen principal del centro */
     public function getStorageId()
     {
         return Room::where([['idUsuario', Auth::user()->id], ['nombre', 'Almacen']])->get(['idSala']);
     }

    /* Función que devuelve si la sala es el almacen del centro o no */
    public function isStorage($id){
        if ($id == $this->getStorageId()[0]['idSala']) {
            return true;
        }else{
            return false;
        }
    }

    /* Función que devuelve si hay alguna relación existente entre un centro y un socio */
    public function resourcesRelationsExists($id)
    {
        if (
            Resource::where([
                ['idSala', $id],
                ['deshabilitado', false],
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }
    /* Metodo que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'nombre' => 'required|max:30',
        ]);
    }
}
