@extends('layouts.app')

@section('content')
<h1>Administrar Pedidos</h1>

<form method="GET" action="{{ route('admin.orders.index') }}">
  <label>Estado:</label>
  <select name="estado">
    <option value="">Todos</option>
    @foreach($estadosPosibles as $e)
      <option value="{{ $e }}" @selected(($filters['estado'] ?? '') === $e)>{{ $e }}</option>
    @endforeach
  </select>

  <label>Últimos días:</label>
  <input type="number" name="dias" min="1" max="365" value="{{ $filters['dias'] ?? '' }}">

  <button type="submit">Filtrar</button>
</form>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top:12px;">
  <tr>
    <th>#Pedido</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Estado</th>
    <th></th>
  </tr>

  @foreach($orders['data'] as $o)
    <?php $last = $o->history[0] ?? null; ?>
    <tr>
      <td>{{ $o->id_pedido }}</td>
      <td>{{ $o->user?->nombre }} ({{ $o->user?->email }})</td>
      <td>{{ $o->fecha }}</td>
      <td>${{ number_format($o->total,2) }}</td>
      <td>{{ $last?->estado }}</td>
      <td><a href="{{ route('admin.orders.show',$o->id_pedido) }}">Ver</a></td>
    </tr>
  @endforeach
</table>

<?php
  $page = (int)($orders['page'] ?? 1);
  $per = (int)($orders['perPage'] ?? 15);
  $total = (int)($orders['total'] ?? 0);
  $pages = (int)ceil($total / max(1,$per));
  $qsBase = $filters;
?>

@if($pages > 1)
  <div style="margin-top:12px;">
    @if($page > 1)
      <a href="{{ route('admin.orders.index') }}?{{ http_build_query(array_merge($qsBase, ['page'=>$page-1])) }}">← Anterior</a>
    @endif
    <span style="margin:0 10px;">Página {{ $page }} de {{ $pages }}</span>
    @if($page < $pages)
      <a href="{{ route('admin.orders.index') }}?{{ http_build_query(array_merge($qsBase, ['page'=>$page+1])) }}">Siguiente →</a>
    @endif
  </div>
@endif
@endsection
