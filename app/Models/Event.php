<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'idSala',
        'titulo',
        'entidadOrg',
        'numeroAsistentes',
        'fechaEvento',
        'horaEvento',
        'informacion',
        'deshabilitado'
    ];
}
