<?php

namespace App\Http\Controllers\Services\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService extends Controller
{
    /* Metodo que realiza la verificación de sus credenciales */
    public function verify(Request $req)
    {
        return 'AAAA';
        /* $cred = $req->validate([
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        if (Auth::attempt($cred)) {
            session('user', Auth::user()->username);
            session('rol', Auth::user()->rol);
            
            return response()->json([
                'status' => true,
                'message' => 'Se ha iniciado sesión!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Credenciales erroneas!'
            ]);
        } */
    }
}
