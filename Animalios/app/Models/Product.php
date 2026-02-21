<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'id_marca',
        'id_subcategoria'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_marca');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_subcategoria');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_producto');
    }
}