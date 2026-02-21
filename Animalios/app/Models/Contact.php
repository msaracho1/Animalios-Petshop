<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacto';
    protected $primaryKey = 'id_contacto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
        'fecha'
    ];
}