<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /carrito
    public function index()
    {
        $cart = session()->get('cart', []); // [id_producto => ['product'=>..., 'qty'=>...]]
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // POST /carrito/agregar
    public function add(Request $request)
    {
        $request->validate([
            'id_producto' => ['required', 'integer'],
            'cantidad' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $id = (int) $request->id_producto;
        $qty = (int) ($request->cantidad ?? 1);

        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id_producto' => $product->id_producto,
                'name' => $product->nombre,
                'price' => (float) $product->precio,
                'qty' => 0,
            ];
        }

        $cart[$id]['qty'] += $qty;

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    // POST /carrito/actualizar
    public function update(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id_producto' => ['required', 'integer'],
            'items.*.qty' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $cart = session()->get('cart', []);

        foreach ($request->items as $item) {
            $id = (int) $item['id_producto'];
            $qty = (int) $item['qty'];

            if (!isset($cart[$id])) continue;

            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado.');
    }

    // POST /carrito/quitar
    public function remove(Request $request)
    {
        $request->validate([
            'id_producto' => ['required', 'integer'],
        ]);

        $id = (int) $request->id_producto;

        $cart = session()->get('cart', []);
        unset($cart[$id]);

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto quitado del carrito.');
    }
}