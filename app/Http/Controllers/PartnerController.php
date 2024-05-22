<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerUser;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PartnerController extends Controller
{
    /* Función que devolvera la lista de los socios */
    public function index()
    {
        try {
            /* Recoge todas las relaciones de los socios con el centro */
            $ids = PartnerUser::where([
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', false]
            ])->get(['dni']);

            /* Recoge todos los socios relacionados con el centro */
            $objs = Partner::whereIn('dni', $ids)->paginate(25);

            return view('partners.list')->with('data', $objs);
        } catch (Exception $err) {
            echo $err;
            return redirect()->route('app.show')->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que envia a la lista de socios filtrada */
    public function filter(Request $req)
    {
        /* Comprueba si alguno de los campos ha sido rellenado */
        if (!$req->filled('dni') && !$req->filled('nombre') && !$req->filled('apellido') && !$req->filled('fecha')) {
            return redirect()->route('partner.index');
        } else {
            try {
                $query = Partner::query();

                /* Recoge todas las relaciones de los socios con el centro */
                $ids = PartnerUser::where([
                    ['idUsuario', Auth::user()->id],
                    ['deshabilitado', false]
                ])->get(['dni']);

                /* Comprueba si los campos se han rellenado y añade las condiciones */
                if ($req->filled('dni')) {
                    $query->where('dni', $req->dni);
                }

                if ($req->filled('nombre')) {
                    $query->where('prNombre', 'like', '%' . $req->nombre . '%');
                    $query->where('SgNombre', 'like', '%' . $req->nombre . '%');
                }

                if ($req->filled('apellido')) {
                    $query->where('prApellido', 'like', '%' . $req->apellido . '%');
                    $query->where('sgApellido', 'like', '%' . $req->apellido . '%');
                }

                if ($req->filled('fecha')) {
                    $query->where('fechaNacimiento', $req->fecha);
                }

                /* Recoge los socios del centro */
                $query->whereIn('dni', $ids);

                $objs = $query->paginate(25);
                return view('partners.list')->with('data', $objs);
            } catch (Exception $err) {
                echo $err;
                return redirect()->route('app.show')->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que devuelve el formulario de crear un socio */
    public function createIndex()
    {
        return view('partners.create');
    }

    /* Función que crea un nuevo socio */
    public function store(Request $req)
    {

        /* Comprueba si el socio ya se ha creado anteriormente */
        if ($this->partnerExists($req->dni)) {

            /* Comprueba si el socio esta deshabilitado */
            if ($this->partnerIsDisabled($req->dni)) {

                /* Habilita el socio */
                $this->activePartner($req->dni);
            }

            /* Comprueba si hay una relación entre el centro y el socio y si esta deshabilitado */
            if ($this->userRelationIsDisabled($req->dni)) {
                $this->activeUserRelation($req->dni);
                return redirect()->back()->with('info', [
                    'message' => 'Socio creado con exito!'
                ]);

                /* Comprueba si hay una relación entre el centro y el socio*/
            } else if ($this->userRelationExists($req->dni)) {
                return redirect()->back()->with('info', [
                    'error' => true,
                    'message' => 'El usuario ya esta relacionado!'
                ]);
            } else {
                PartnerUser::create([
                    'idUsuario' => Auth::user()->id,
                    'dni' => $req->dni,
                    'fechaAlta' => date('Y-m-d')
                ]);
                return redirect()->back()->with('info', [
                    'message' => 'Socio creado con exito!'
                ]);
            }
        } else {

            /* Validacion de los atributos numericos */
            if ($this->checkNumeric($req->cp, $req->tel, $req->prTelResp, $req->sgTelResp)) {

                /* Validación de los atributos restantes */
                $val = $req->validate([
                    'dni' => 'required|unique:partners|max:9',
                    'prNombre' => 'required|max:20',
                    'sgNombre' => 'max:20',
                    'prApellido' => 'required|max:20',
                    'sgApellido' => 'max:20',
                    'fechaNacimiento' => 'required|date',
                    'direccion' => 'required|max:50',
                    'localidad' => 'required|max:20',
                    'email' => 'required|email|max:50',
                    'foto' => 'image|dimensions:max_width=400,max_height=400'
                ]);
                if ($req->file('foto')) {
                    $photo = file_get_contents($req->file('foto'));
                } else {
                    $photo = File::get(public_path('media/img/user-default.png'));
                }
                /* Almacenamos toda la información del socio */
                $data = [
                    'dni' => $req->dni,
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
                    'foto' => base64_encode($photo)
                ];

                /* Creación del socio */
                try {
                    Partner::create($data);
                    PartnerUser::create([
                        'idUsuario' => Auth::user()->id,
                        'dni' => $req->dni,
                        'fechaAlta' => date('Y-m-d')
                    ]);
                    return redirect()->back()->with('info', ['message' => 'Socio creado con exito!']);
                } catch (Exception $err) {
                    return redirect()->back()->with('info', [
                        'error' => $err,
                        'message' => 'Algo no ha ido bien!'
                    ]);
                }
            }
        }
    }

    /* Función que deshabilita el socio */
    public function disable(Request $req)
    {

        /* Deshabilita la relación del centro con el socio */
        $this->disableUserRelation($req->dni);

        /* Comprueba si no existe alguna relacion con el socio */
        if (!$this->usersRelationsExists($req->dni)) {

            /* Deshabilita el socio */
            $this->disablePartner($req->dni);
        }
        return redirect()->back()->with('info', ['message' => 'Socio eliminado con exito!']);

    }

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerExists($dni)
    {
        if (Partner::where('dni', $dni)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si el socio ya ha sido relacionado anteriormente */
    public function userRelationExists($dni)
    {
        if (
            PartnerUser::where([
                ['dni', $dni],
                ['idUsuario', Auth::user()->id],
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si hay alguna relación existente entre un centro y un socio */
    public function usersRelationsExists($dni)
    {
        if (
            PartnerUser::where([
                ['dni', $dni],
                ['deshabilitado', false],
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerIsDisabled($dni)
    {
        if (
            Partner::where([
                ['dni', $dni],
                ['deshabilitado', true]
            ])->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* Función que devuelve si la relación con el usuario esta deshabilitada*/
    public function userRelationIsDisabled($dni)
    {
        if (
            PartnerUser::where([
                ['dni', $dni],
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
    public function activePartner($dni)
    {
        if (
            Partner::where([
                ['dni', $dni],
                ['deshabilitado', true]
            ])->exists()
        ) {
            Partner::where([
                ['dni', $dni],
                ['deshabilitado', true]
            ])->update(['deshabilitado' => false]);
        }
    }

    /* Metodo que activa la relacion con el usuario */
    public function activeUserRelation($dni)
    {
        if (
            PartnerUser::where([
                ['dni', $dni],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', true]
            ])->exists()
        ) {
            PartnerUser::where([
                ['dni', $dni],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', true]
            ])->update(['deshabilitado' => false]);
        }
    }


    /* Funcion que realiza la deshabilitación del socio */
    public function disablePartner($dni)
    {
        Partner::where([
            ['dni', $dni],
            ['deshabilitado', false]
        ])->update(['deshabilitado' => true]);
    }

    /* Funcion que realiza la deshabilitación del socio */
    public function disableUserRelation($dni)
    {
        PartnerUser::where([
            ['dni', $dni],
            ['idUsuario', Auth::user()->id],
            ['deshabilitado', false]
        ])->update(['deshabilitado' => true]);
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
        if (is_numeric($cp) && is_numeric($tel) && is_numeric($prTelResp)) {
            if (strlen($cp) > 5) {
                $val = false;
            }
            if (strlen($tel) != 9) {
                $val = false;
            }
            if (strlen($prTelResp) != 9) {
                $val = false;
            }
        } else {
            $val = false;
        }

        return $val;
    }
}
