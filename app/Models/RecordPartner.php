<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordPartner extends Model
{
    use HasFactory;

    protected $table = 'partners_records';

    protected $fillable = [
        'idRegistro',
        'idSocio'
    ];
}
