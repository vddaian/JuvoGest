<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'expulsado',
        'dni',
        'prNombre',
        'sgNombre',
        'prApellido',
        'sgApellido',
        'fechaNacimiento',
        'edad',
        'direccion',
        'localidad',
        'cp',
        'telefono',
        'prTelefonoResp',
        'sgTelefonoResp',
        'email',
        'alergias',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'dni',
    ];

}
