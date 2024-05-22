<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;

class PartnerController extends Controller
{
    /* Función que devolvera la lista de los socios */
    public function index()
    {
        try {
            // Recoge todas las relaciones de los socios con el centro .-
            $ids = PartnerUser::where([
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', false]
            ])->get(['idSocio']);

            // Recoge todos los socios relacionados con el centro .-
            $objs = Partner::whereIn('idSocio', $ids)->paginate(25);

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
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('dni') && !$req->filled('nombre') && !$req->filled('apellido') && !$req->filled('fecha')) {
            return redirect()->route('partner.index');
        } else {
            try {
                $query = Partner::query();

                // Recoge todas las relaciones de los socios con el centro .-
                $ids = PartnerUser::where([
                    ['idUsuario', Auth::user()->id],
                    ['deshabilitado', false]
                ])->get(['idSocio']);

                // Comprueba si los campos se han rellenado y añade las condiciones .-
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

                // Recoge los socios del centro .-
                $query->whereIn('idSocio', $ids);

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

    /* Función que crea un nuevo socio */
    public function store(Request $req)
    {

        // Comprueba si el socio ya se ha creado anteriormente, en caso de que este exista recogera su id .-
        $id = $this->partnerExists($req->dni, $req->fechaNacimiento);

        if ($id) {

            // Comprueba si el socio esta deshabilitado .-
            if ($this->partnerIsDisabled($id)) {

                /* Habilita el socio */
                $this->activePartner($id);
            }

            // Comprueba si hay una relación entre el centro y el socio y si esta deshabilitado .-
            if ($this->userRelationIsDisabled($id)) {
                $this->activeUserRelation($id);
                return redirect()->back()->with('info', [
                    'message' => 'Socio creado con exito!'
                ]);

                // Comprueba si hay una relación entre el centro y el socio .-
            } else if ($this->userRelationExists($id)) {
                return redirect()->back()->with('info', [
                    'error' => true,
                    'message' => 'El usuario ya esta relacionado!'
                ]);
            } else {
                PartnerUser::create([
                    'idUsuario' => Auth::user()->id,
                    'idSocio' => $id,
                    'fechaAlta' => date('Y-m-d')
                ]);
                return redirect()->back()->with('info', [
                    'message' => 'Socio creado con exito!'
                ]);
            }
        } else {

            // Validacion de los atributos numericos .-
            if ($this->checkNumeric($req->cp, $req->tel, $req->prTelResp, $req->sgTelResp)) {

                // Validación de los atributos restantes .-
                $val = $this->validateOthers($req);
                $req->validate([
                    'dni' => 'required|unique:partners|max:9',
                ]);
                // Comprueba si el campo de la imagen se ha rellenado .-
                if ($req->file('foto')) {
                    $photo = file_get_contents($req->file('foto'));
                } else {
                    $photo = FacadesFile::get(public_path('media/img/user-default.png'));
                }
                // Almacenamos toda la información del socio .-
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

                // Creación del socio .-
                try {
                    Partner::create($data);

                    // Recoge el id del socio recien creado .-
                    $id = $this->getPartnerId($req->dni);

                    PartnerUser::create([
                        'idUsuario' => Auth::user()->id,
                        'idSocio' => $id,
                        'fechaAlta' => date('Y-m-d')
                    ]);
                    return redirect()->back()->with('info', ['message' => 'Socio creado con exito!']);
                } catch (Exception $err) {
                    return redirect()->back()->with('info', [
                        'error' => $err,
                        'message' => 'Algo no ha ido bien!'
                    ]);
                }
            } else {
                return redirect()->back();
            }
        }
    }

    /* Función que realiza la actualización del socio */
    public function update()
    {
    }

    /* Función que devuelve el id del usuario */
    public function getPartnerId($dni)
    {
        return Partner::where('dni', $dni)->get(['idSocio'])[0]['idSocio'];
    }

    /* Función que devuelve toda la información del socio */
    public function getPartnerInfo($id)
    {
        return Partner::where('idSocio', $id)->get();
    }

    /* Función que deshabilita el socio */
    public function disable(Request $req)
    {

        // Deshabilita la relación del centro con el socio .-
        $this->disableUserRelation($req->id);

        // Comprueba si no existe alguna relacion con el socio .-
        if (!$this->usersRelationsExists($req->id)) {

            // Deshabilita el socio .-
            $this->disablePartner($req->id);
        }
        return redirect()->back()->with('info', ['message' => 'Socio eliminado con exito!']);
    }

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerExists($dni, $fecha)
    {
        if (Partner::where([
            ['dni', $dni],
            ['fechaNacimiento', $fecha]
        ])->exists()) {
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


    /* Función que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'dni' => 'required|max:9',
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
