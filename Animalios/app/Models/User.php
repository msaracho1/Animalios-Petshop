<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'contraseña',
        'id_rol'
    ];

    protected $hidden = [
        'contraseña'
    ];

    // Relaciones
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_usuario');
    }
}