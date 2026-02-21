@extends('layouts.app')

@section('content')
<h1>Pedido #{{ $order->id_pedido }}</h1>

@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

<p><strong>Fecha:</strong> {{ $order->fecha }}</p>
<p><strong>Total:</strong> ${{ number_format($order->total,2) }}</p>

<h3>Productos</h3>

<table border="1" cellpadding="8">
  <tr>
    <th>Producto</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Subtotal</th>
  </tr>

  @foreach($order->items as $item)
    <tr>
      <td>{{ $item->product->nombre }}</td>
      <td>${{ number_format($item->precio,2) }}</td>
      <td>{{ $item->cantidad }}</td>
      <td>${{ number_format($item->precio * $item->cantidad,2) }}</td>
    </tr>
  @endforeach
</table>

<h3>Historial</h3>

<ul>
@foreach($order->history as $h)
  <li>{{ $h->fecha }} — {{ $h->estado }}</li>
@endforeach
</ul>

<a href="{{ route('orders.index') }}">← Volver</a>
@endsection