<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategoria';
    protected $primaryKey = 'id_subcategoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_categoria'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_categoria');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_subcategoria');
    }
}