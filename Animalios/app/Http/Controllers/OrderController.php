<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user','history'])
            ->orderByDesc('fecha');

        // filtro por estado (toma el último estado del historial)
        if ($request->filled('estado')) {
            $estado = $request->estado;
            $query->whereHas('history', function ($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }

        // filtro últimos X días
        if ($request->filled('dias')) {
            $dias = (int)$request->dias;
            if ($dias > 0 && $dias <= 365) {
                $query->where('fecha', '>=', now()->subDays($dias));
            }
        }

        $orders = $query->paginate(15)->withQueryString();

        $estadosPosibles = ['Pendiente','En verificación','En preparación','En camino','Recibido','Cancelado'];

        return view('admin.orders.index', compact('orders','estadosPosibles'));
    }

    public function show($id)
    {
        $order = Order::with(['user','items.product','history'])
            ->findOrFail($id);

        $estadosPosibles = ['Pendiente','En verificación','En preparación','En camino','Recibido','Cancelado'];

        return view('admin.orders.show', compact('order','estadosPosibles'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => ['required','string','max:50'],
        ]);

        $order = Order::findOrFail($id);

        OrderHistory::create([
            'id_pedido' => $order->id_pedido,
            'estado' => $request->estado,
            'fecha' => now(),
        ]);

        return redirect()->route('admin.orders.show', $order->id_pedido)
            ->with('success', 'Estado actualizado.');
    }
}