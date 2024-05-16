<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerUser extends Model
{
    use HasFactory;
    protected $table = 'partners_users';
    protected $fillable = [
        'dni',
        'idUsuario'
    ];

    protected $hidden = [
        'dni',
        'idUsuario'
    ];
}
