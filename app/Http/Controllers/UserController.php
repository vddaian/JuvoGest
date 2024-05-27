<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Str;

class UserController extends Controller
{
    /* Función que redirige al register */
    public function registerIndex()
    {
        return view('auth.register');
    }

    /* Funcion que redirige al login */
    public function loginIndex()
    {
        return view('auth.login');
    }

    /* Funcion que realiza el registro del usuario */
    public function store(Request $req)
    {
        $val = true;
        
        /* Validacion de los atributos numericos */
        if (is_numeric($req->cp) && is_numeric($req->telefono)) {
            if (strlen($req->cp) > 5) {
                $val = false;
            }
            if (strlen($req->telefono) != 9) {
                $val = false;
            }
            if ($val) {
                /* Validación de los atributos restantes */
                $val = $req->validate([
                    'nombreEntidad' => 'max:30',
                    'username' => 'required|unique:users|max:20',
                    'password' => 'required',
                    'direccion' => 'required|max:50',
                    'localidad' => 'required|max:20',
                    'email' => 'required|email|max:50',
                    'foto' => 'required|image|dimensions:max_width=400,max_height=400'
                ]);

                $data = [
                    'id' => Str::uuid(),
                    'nombreEntidad' => $req->nombreEntidad,
                    'username' => $req->username,
                    'password' => Hash::make($req->password),
                    'direccion' => $req->direccion,
                    'localidad' => $req->localidad,
                    'cp' => $req->cp,
                    'telefono' => $req->telefono,
                    'email' => $req->email,
                    'foto' => base64_encode(file_get_contents($req->file('foto')))
                ];

                /* Creación del usuario */
                try {
                    User::create($data);
                    Room::create([
                        'idUsuario' => $data['id'],
                        'nombre' => 'Almacen',
                        'tipo'=>'MEDIANA',
                        'informacion' => 'Sala donde se almacenan todos los recursos que se den de alta o se eliminen de una sala.'
                    ]);
                    return redirect()->back()->with('data', 'Cuenta creada con exito!');
                } catch (Exception $err) {
                    echo $err;
                    return redirect()->back()->with('data',[
                        'error' => $err,
                        'message' => 'Algo no ha ido bien!',
                    ]);
                }
            }
        }
    }

    /* Funcion que realiza la comprobación de credenciales */
    public function verify(Request $req)
    {
        $val = $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'username' => $req->username,
            'password'=> $req->password
        ];

        if (Auth::attempt($data)) {
            session()->put('user', Auth::user()->username);
            session()->put('rol', Auth::user()->rol);
            session()->put('foto', Auth::user()->foto);
            return redirect()->route('app.index');
        } else {
            return redirect()->back()->with('info', 'Credenciales incorrectas!');
        }
    }

    /* Función que desconecta el usuario */
    public function logout(){
        Auth::logout();
        session(['rol' => null]);
        session(['user' => null]);
        session(['foto' => null]);
        return redirect()->route('login.index');
    }
}
