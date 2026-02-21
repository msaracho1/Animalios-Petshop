<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_marca');
    }
}