<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}