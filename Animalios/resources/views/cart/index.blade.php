@extends('layouts.app')

@section('content')
  <h1>Carrito</h1>

  @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
  @endif

  @if(empty($cart))
    <p>Tu carrito está vacío.</p>
    <a href="{{ route('store.index') }}">Ir a la tienda</a>
  @else

    <form method="POST" action="{{ route('cart.update') }}">
      @csrf

      <table border="1" cellpadding="8" cellspacing="0">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $item)
            <tr>
              <td>{{ $item['name'] }}</td>
              <td>${{ number_format($item['price'], 2) }}</td>
              <td>
                <input type="hidden" name="items[{{ $loop->index }}][id_producto]" value="{{ $item['id_producto'] }}">
                <input type="number" min="0" max="99" name="items[{{ $loop->index }}][qty]" value="{{ $item['qty'] }}">
              </td>
              <td>${{ number_format($item['price'] * $item['qty'], 2) }}</td>
              <td>
                <form method="POST" action="{{ route('cart.remove') }}">
                  @csrf
                  <input type="hidden" name="id_producto" value="{{ $item['id_producto'] }}">
                  <button type="submit">Quitar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>

      <button type="submit">Actualizar carrito</button>
    </form>

    <hr>

    {{-- Checkout lo implementamos en el próximo paso --}}
    <form method="POST" action="{{ route('checkout') }}">
      @csrf
      <button type="submit">Finalizar compra</button>
    </form>

  @endif
@endsection