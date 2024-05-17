<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /* Función que redirige al register */
    public function index()
    {
        return view('auth.register');
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
}
