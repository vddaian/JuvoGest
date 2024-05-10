<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /* Función que redirije al usuario al home o al login */
    public function index(){
        if (Auth::check()) {
            return redirect()->route('home');
        }else {
            return redirect()->route('login.index');
        }
    }
}
