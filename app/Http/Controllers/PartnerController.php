<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerUser;
use Exception;
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
                ['deshabilitado', false]])->get(['dni']);

            /* Recoge todos los socios relacionados con el centro */
            $objs = Partner::whereIn('dni', $ids)->get();

            return view('partners.list')->with('data', $objs);
        } catch (Exception $err) {
            echo $err;
            return redirect()->route('app.show')->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
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

            /* Comprueba si hay una relación entre el centro y el socio y si esta deshabilitado */
            if (
                PartnerUser::where([
                    ['dni', $req->dni],
                    ['idUsuario', Auth::user()->id],
                    ['deshabilitado', true]
                ])->exists()
            ) {
                PartnerUser::where([
                    ['dni', $req->dni],
                    ['idUsuario', Auth::user()->id],
                    ['deshabilitado', true]
                ])->update(['deshabilitado' => 'false']);
                return redirect()->back()->with('info', [
                    'message' => 'Socio creado con exito!'
                ]);

                /* Comprueba si hay una relación entre el centro y el socio*/
            } else if (PartnerUser::where([
                ['dni', $req->dni],
                ['idUsuario', Auth::user()->id],
            ])->exists()) {
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
                echo 'Los numeros estan bien';
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
                    'foto' => 'required|image|dimensions:max_width=400,max_height=400'
                ]);

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
                    'foto' => base64_encode(file_get_contents($req->file('foto')))
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

    /* Función que devuelve si el socio ya ha sido creado anteriormente */
    public function partnerExists($dni)
    {
        if (Partner::where('dni', $dni)->exists()) {
            return true;
        } else {
            return false;
        }
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
            } else{
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

    /*  public function indexWFilter(Request $req)
    {
    } */
}
