<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
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
            session('user', Auth::user()->username);
            session('rol', Auth::user()->rol);
            echo 'Logueado';
            return redirect()->route('app.index');
        } else {
            echo 'No Logueado';
            return redirect()->back()->with('message', 'Credenciales incorrectas!');
        }
    }
}
