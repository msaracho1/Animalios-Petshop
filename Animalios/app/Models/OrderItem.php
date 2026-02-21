<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'precio'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_pedido');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}