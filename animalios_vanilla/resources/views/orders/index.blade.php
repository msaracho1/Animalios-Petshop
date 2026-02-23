@extends('layouts.app')

@section('content')
<h1>Mis pedidos</h1>

@if(empty($orders))
  <p>No tenés pedidos todavía.</p>
@else

<table border="1" cellpadding="8">
  <tr>
    <th>#</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Estado</th>
    <th></th>
  </tr>

  @foreach($orders as $o)
    <?php $last = $o->history[0] ?? null; ?>
    <tr>
      <td>{{ $o->id_pedido }}</td>
      <td>{{ $o->fecha }}</td>
      <td>${{ number_format($o->total,2) }}</td>
      <td>{{ $last?->estado }}</td>
      <td>
        <a href="{{ route('orders.show',$o->id_pedido) }}">Ver</a>
      </td>
    </tr>
  @endforeach

</table>

@endif
@endsection
