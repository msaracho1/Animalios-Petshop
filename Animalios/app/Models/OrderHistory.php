<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'historial_pedido';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'estado',
        'fecha'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_pedido');
    }
}