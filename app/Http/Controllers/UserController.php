<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Str;

class UserController extends Controller
{
    /* Función que redirige a la lista de usuarios */
    public function index()
    {
        $usrs = User::where([['deshabilitado', false], ['id', '!=', Auth::user()->id]])->paginate(25);
        return view('admin.users.list')->with('data', $usrs);
    }
    /* Función que redirige al register */
    public function createIndex()
    {
        return view('admin.users.create');
    }

    /* Función que redirige al formulario de edición del usuario */
    public function editIndex($id)
    {
        $usr = User::where('id', $id)->get();
        return view('admin.users.edit')->with('data', $usr);
    }

    /* Función que redirige a la vista del usuario */
    public function viewIndex($id)
    {
        $usr = User::where('id', $id)->get();
        return view('admin.users.view')->with('data', $usr);
    }


    /* Funcion que redirige al login */
    public function loginIndex()
    {
        return view('auth.login');
    }

    /* Función que envia a la lista de usuarios filtrada */
    public function filter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('entidad') && !$req->filled('usuario') && !$req->filled('localidad')) {
            return redirect()->route('user.index');
        } else {
            try {
                $query = User::query();

                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('entidad')) {
                    $query->where('nombreEntidad', 'like', '%' . $req->entidad . '%');
                }

                if ($req->filled('usuario')) {
                    $query->where('username', 'like', '%' . $req->usuario . '%');
                }

                if ($req->filled('localidad')) {
                    $query->where('localidad', 'like', '%' . $req->localidad . '%');
                }

                // Recoge los socios del centro .-
                $query->where([['deshabilitado', false], ['id', '!=', Auth::user()->id]]);

                $objs = $query->paginate(25);
                return view('admin.users.list')->with('data', $objs);
            } catch (Exception $err) {
                echo $err;
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }


    /* Funcion que realiza el registro del usuario */
    public function store(Request $req)
    {
        $val = true;

        // Validacion de los atributos numericos .-
        if (is_numeric($req->cp) && is_numeric($req->telefono)) {
            if (strlen($req->cp) > 5) {
                $val = false;
            }
            if (strlen($req->telefono) != 9) {
                $val = false;
            }
            if ($val) {
                // Validación de los atributos restantes .-
                $val = $req->validate([
                    'nombreEntidad' => 'max:30',
                    'username' => 'required|unique:users|max:20',
                    'password' => 'required',
                    'direccion' => 'required|max:50',
                    'localidad' => 'required|max:20',
                    'email' => 'required|email|max:50',
                    'foto' => 'image|dimensions:max_width=400,max_height=400'
                ]);

                if ($req->file('foto')) {
                    $photo = base64_encode(file_get_contents($req->file('foto')));
                } else {
                    $photo = base64_encode(FacadesFile::get(public_path('media/img/user-default.png')));
                }

                $data = [
                    'id' => Str::uuid(),
                    'nombreEntidad' => $req->nombreEntidad,
                    'username' => $req->username,
                    'password' => Hash::make($req->password),
                    'direccion' => $req->direccion,
                    'localidad' => $req->localidad,
                    'rol' => $req->rol,
                    'cp' => $req->cp,
                    'telefono' => $req->telefono,
                    'email' => $req->email,
                    'foto' => $photo
                ];

                // Creación del usuario 
                try {
                    User::create($data);
                    Room::create([
                        'idUsuario' => $data['id'],
                        'nombre' => 'Almacen',
                        'tipo' => 'MEDIANA',
                        'informacion' => 'Sala donde se almacenan todos los recursos que se den de alta o se eliminen de una sala.'
                    ]);
                    return redirect()->back()->with('info', ['message' => 'Cuenta creada con exito!']);
                } catch (Exception $err) {
                    echo $err;
                    return redirect()->back()->with('info', [
                        'error' => $err,
                        'message' => 'Algo no ha ido bien!',
                    ]);
                }
            }
        }
    }

    /* Función que realiza la actualización del usuario */
    public function update(Request $req)
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
                if (!$req->username == $this->getUsername($req->id)) {
                    $val = $req->validate([
                        'nombreEntidad' => 'max:30',
                        'username' => 'required|unique:users|max:20',
                        'direccion' => 'required|max:50',
                        'localidad' => 'required|max:20',
                        'email' => 'required|email|max:50',
                        'foto' => 'image|dimensions:max_width=400,max_height=400'
                    ]);
                } else {
                    $val = $req->validate([
                        'nombreEntidad' => 'max:30',
                        'direccion' => 'required|max:50',
                        'localidad' => 'required|max:20',
                        'email' => 'required|email|max:50',
                        'foto' => 'image|dimensions:max_width=400,max_height=400'
                    ]);
                }

                if ($req->file('foto')) {
                    $photo = base64_encode(file_get_contents($req->file('foto')));
                } else {
                    $photo = $this->getUserPhoto($req->id);
                }

                $data = [
                    'nombreEntidad' => $req->nombreEntidad,
                    'username' => $req->username,
                    'direccion' => $req->direccion,
                    'localidad' => $req->localidad,
                    'rol' => $req->rol,
                    'cp' => $req->cp,
                    'telefono' => $req->telefono,
                    'email' => $req->email,
                    'foto' => $photo
                ];

                // Actualización del usuario .-
                try {
                    User::where('id', $req->id)->update($data);

                    if ($req->password) {
                        User::where('id', $req->id)->update(['password' => Hash::make($req->password)]);
                    }

                    return redirect()->back()->with('info', ['message' => 'Cuenta actualizada con exito!']);
                } catch (Exception $err) {
                    echo $err;
                    return redirect()->back()->with('info', [
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
            'password' => $req->password
        ];

        if (Auth::attempt($data)) {
            session()->put('user', Auth::user()->username);
            session()->put('rol', Auth::user()->rol);
            session()->put('name', Auth::user()->nombreEntidad);
            session()->put('storage',RoomController::getStorageId());
            session()->put('foto', Auth::user()->foto);
            session()->put('id', Auth::user()->id);
            return redirect()->route('app.index');
        } else {
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'Credenciales erroneas, revisa y prueba de nuevo!',
            ]);
        }
    }

    /* Función que desconecta el usuario */
    public function logout()
    {
        Auth::logout();
        session(['rol' => null]);
        session(['user' => null]);
        session(['storage' => null]);
	session(['name' => null]);
        session(['id' => null]);
        session(['foto' => null]);
        return redirect()->route('login.index');
    }

    /* Función que devuelve el id del usuario */
    public function getUserPhoto($id)
    {
        return User::where('id', $id)->get(['foto'])[0]['foto'];
    }

    /* Función que devuelve el id del usuario */
    public function getUsername($id)
    {
        return User::where('id', $id)->get(['username'])[0]['username'];
    }
}
