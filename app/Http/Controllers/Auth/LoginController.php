<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        /* echo url('').'/api/login'; */
        $opciones = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => ''
            )
        );

        $contexto = stream_context_create($opciones);

        $resultado = file_get_contents('http://127.0.0.1:8002/api/login', false, $contexto);
        return $resultado;
    }
}
