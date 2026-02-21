<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_pedido');
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'id_pedido');
    }
}