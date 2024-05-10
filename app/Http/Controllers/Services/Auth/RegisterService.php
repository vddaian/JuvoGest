<?php

namespace App\Http\Controllers\Services\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterService extends Controller
{
    /* Función que crea un usuario */
    public function store(Request $req)
    {
        $data = $req->validate([
            'nombreEntidad' => 'max:30',
            'username' => 'required|unique:users|max:20',
            'password' => 'required',
            'direccion' => 'max:50',
            'localidad' => 'max:20',
            'cp' => 'max:5',
            'telefono'=> 'max:9',
            'email' => 'max:50'
        ]);
        try {
            User::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Se ha registrado con existo!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Algo ha ido mal!'
            ]);
        }
    }
}
