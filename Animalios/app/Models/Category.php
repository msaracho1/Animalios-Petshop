<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'id_categoria');
    }
}