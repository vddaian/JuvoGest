<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /* Función que redirige al register */
    public function index(){
        return view('register');
    }

    /* Funcion que realiza el registro del usuario */
    public function store(){
        
    }
}
