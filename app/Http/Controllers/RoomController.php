<?php

namespace App\Http\Controllers;

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
            return redirect()->route('partner.index');
        } else {
            try {
                $query = Partner::query();

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

    /* Función que devuelve la página de edición del socio */
    public function editIndex($id)
    {
        return view('partners.edit')->with('data', $this->getPartnerInfo($id));
    }

    /* Función que devuelve la página de visualización del socio */
    public function viewIndex($id)
    {
        return view('partners.view')->with('data', $this->getPartnerInfo($id));
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

    /* Función que realiza la actualización del socio */
    public function update(Request $req)
    {

        // Valida los datos numericos .-
        if ($this->checkNumeric($req->cp, $req->tel, $req->prTelResp, $req->sgTelResp)) {
            try {
                // Valida los demas campos .-
                $val = $this->validateOthers($req);

                // Comprueba si el campo de la imagen ha sido rellenada .-
                if ($req->file('foto')) {
                    $photo = base64_encode(file_get_contents($req->file('foto')));
                } else {
                    $photo = $this->getPartnerPhoto($req->id);
                }

                // Almacenamos toda la información del socio .-
                $data = [
                    'prNombre' => $req->prNombre,
                    'sgNombre' => $req->sgNombre,
                    'prApellido' => $req->prApellido,
                    'sgApellido' => $req->sgApellido,
                    'fechaNacimiento' => $req->fechaNacimiento,
                    'direccion' => $req->direccion,
                    'localidad' => $req->localidad,
                    'cp' => $req->cp,
                    'telefono' => $req->tel,
                    'prTelefonoResp' => $req->prTelResp,
                    'sgTelefonoResp' => $req->sgTelResp,
                    'email' => $req->email,
                    'alergias' => $req->alergias,
                    'foto' => $photo
                ];



                // Realiza la actualización del socio .-
                Partner::where('idSocio', $req->id)->update($data);

                return redirect()->back()->with('info', ['message' => 'Sala actualizado con exito!']);
            } catch (Exception $err) {

                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que deshabilita la sala */
    public function disable(Request $req)
    {
        Room::where('idSala', $req->id)->update(['deshabilitado' => true]);
        return redirect()->back()->with('info', ['message' => 'Sala eliminada con exito!']);
    }

    /* Función que devuelve el id del usuario */
    public function getPartnerId($dni)
    {
        return Partner::where('dni', $dni)->get(['idSocio'])[0]['idSocio'];
    }

    /* Función que devuelve el id del usuario */
    public function getPartnerPhoto($id)
    {
        return Partner::where('idSocio', $id)->get(['foto'])[0]['foto'];
    }

    /* Función que devuelve toda la información del socio */
    public function getPartnerInfo($id)
    {
        return Partner::where('idSocio', $id)->get();
    }

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerExists($dni, $fecha)
    {
        if (
            Partner::where([
                ['dni', $dni],
                ['fechaNacimiento', $fecha]
            ])->exists()
        ) {
            return $this->getPartnerId($dni);
        } else {
            return null;
        }
    }

    /* Función que devuelve si el socio ya ha sido relacionado anteriormente */
    public function userRelationExists($id)
    {
        if (
            PartnerUser::where([
                ['idSocio', $id],
                ['idUsuario', Auth::user()->id],
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si hay alguna relación existente entre un centro y un socio */
    public function usersRelationsExists($id)
    {
        if (
            PartnerUser::where([
                ['idSocio', $id],
                ['deshabilitado', false],
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerIsDisabled($id)
    {
        if (
            Partner::where([
                ['idSocio', $id],
                ['deshabilitado', true]
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si la relación con el usuario esta deshabilitada*/
    public function userRelationIsDisabled($id)
    {
        if (
            PartnerUser::where([
                ['idSocio', $id],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', true]
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Metodo que activa un socio */
    public function activePartner($id)
    {
        if (
            Partner::where([
                ['idSocio', $id],
                ['deshabilitado', true]
            ])->exists()
        ) {
            Partner::where([
                ['idSocio', $id],
                ['deshabilitado', true]
            ])->update(['deshabilitado' => false]);
        }
    }

    /* Metodo que activa la relacion con el usuario */
    public function activeUserRelation($id)
    {
        if (
            PartnerUser::where([
                ['idSocio', $id],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', true]
            ])->exists()
        ) {
            PartnerUser::where([
                ['idSocio', $id],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', true]
            ])->update(['deshabilitado' => false]);
        }
    }


    /* Funcion que realiza la deshabilitación del socio */
    public function disablePartner($id)
    {
        Partner::where([
            ['idSocio', $id],
            ['deshabilitado', false]
        ])->update(['deshabilitado' => true]);
    }

    /* Funcion que realiza la deshabilitación del socio */
    public function disableUserRelation($id)
    {
        PartnerUser::where([
            ['idSocio', $id],
            ['idUsuario', Auth::user()->id],
            ['deshabilitado', false]
        ])->update(['deshabilitado' => true]);
    }


    /* Metodo que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'nombre' => 'required|max:30',
        ]);
    }

    /* Funcion que comprueba los atributos numericos */
    public function checkNumeric($cp, $tel, $prTelResp, $sgTelResp)
    {
        $val = true;

        if ($sgTelResp) {
            if (is_numeric($sgTelResp)) {
                if (strlen($sgTelResp) != 9) {
                    $val = false;
                }
            } else {
                $val = false;
            }
        }

        if ($tel) {
            if (is_numeric($tel)) {
                if (strlen($tel) != 9) {
                    $val = false;
                }
            } else {
                $val = false;
            }
        }

        if (is_numeric($cp) && is_numeric($prTelResp)) {
            if (strlen($prTelResp) != 9) {
                $val = false;
            }
        } else {
            $val = false;
        }

        return $val;
    }
}
