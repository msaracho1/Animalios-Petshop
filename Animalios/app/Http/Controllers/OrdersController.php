<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class OrdersController extends Controller
{
    // GET /pedidos
    public function index()
    {
    $orders = Order::with('history')
        ->where('id_usuario', Auth::user()->id_usuario)
        ->orderByDesc('fecha')
        ->get();
        return view('orders.index', compact('orders'));
    }

    // GET /pedidos/{id}
    public function show($id)
    {
        $order = Order::with([
            'items.product',
            'history'
        ])->findOrFail($id);

        // Seguridad: solo dueño
    if ($order->id_usuario !== Auth::user()->id_usuario) {
        abort(403);
    }

        return view('orders.show', compact('order'));
    }
}