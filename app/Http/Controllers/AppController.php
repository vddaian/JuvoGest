<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /* Función que redirije al usuario al home o al login */
    public function index(){
        if (Auth::check()) {
            return redirect()->route('app.show');
        }else {
            return redirect()->route('login.index');
        }
    }

    public function show(){
        return view('index');
    }
}
