<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'El carrito está vacío.');
        }
        $user = Auth::user();

        DB::beginTransaction();

        try {

            // Calcular total
            $total = 0;
            foreach ($cart as $item) {
                $total += ($item['price'] * $item['qty']);
            }

            // Crear pedido
            $order = Order::create([
                'id_usuario' => $user->id_usuario,
                'fecha' => now(),
                'total' => $total,
            ]);

            // Crear detalles
            foreach ($cart as $item) {
                OrderItem::create([
                    'id_pedido' => $order->id_pedido,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $item['qty'],
                    'precio' => $item['price'],
                ]);
            }

            // Historial inicial
            OrderHistory::create([
                'id_pedido' => $order->id_pedido,
                'estado' => 'Pendiente',
                'fecha' => now(),
            ]);

            // Vaciar carrito
            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order->id_pedido)
                ->with('success', 'Pedido realizado correctamente.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', 'Error al procesar el pedido.');
        }
    }
}