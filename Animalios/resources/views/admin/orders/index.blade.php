@extends('layouts.app')

@section('content')
<h1>Administrar Pedidos</h1>

<form method="GET" action="{{ route('admin.orders.index') }}">
  <label>Estado:</label>
  <select name="estado">
    <option value="">Todos</option>
    @foreach($estadosPosibles as $e)
      <option value="{{ $e }}" @selected(request('estado')===$e)>{{ $e }}</option>
    @endforeach
  </select>

  <label>Últimos días:</label>
  <input type="number" name="dias" min="1" max="365" value="{{ request('dias') }}">

  <button type="submit">Filtrar</button>
</form>

@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>#Pedido</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Estado</th>
    <th></th>
  </tr>

  @foreach($orders as $o)
    <tr>
      <td>{{ $o->id_pedido }}</td>
      <td>{{ $o->user?->nombre }} ({{ $o->user?->email }})</td>
      <td>{{ $o->fecha }}</td>
      <td>${{ number_format($o->total,2) }}</td>
      <td>{{ optional($o->history->last())->estado }}</td>
      <td><a href="{{ route('admin.orders.show',$o->id_pedido) }}">Ver</a></td>
    </tr>
  @endforeach
</table>

<div style="margin-top:12px;">
  {{ $orders->links() }}
</div>
@endsection