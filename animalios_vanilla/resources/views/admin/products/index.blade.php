@extends('layouts.app')

@section('content')
<h1>Administrar Productos</h1>

<a href="{{ route('admin.products.create') }}">+ Agregar producto</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top:12px;">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Marca</th>
    <th>Subcategoría</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Acciones</th>
  </tr>

  @foreach($products['data'] as $p)
    <tr>
      <td>{{ $p->id_producto }}</td>
      <td>{{ $p->nombre }}</td>
      <td>{{ $p->brand?->nombre }}</td>
      <td>{{ $p->subcategory?->nombre }}</td>
      <td>${{ number_format($p->precio,2) }}</td>
      <td>{{ $p->stock }}</td>
      <td>
        <a href="{{ route('admin.products.edit', $p->id_producto) }}">Editar</a>

        <form method="POST" action="{{ route('admin.products.destroy', ['id'=>$p->id_producto]) }}" style="display:inline">
          @csrf
          <button type="submit" onclick="return confirm('¿Eliminar producto?')">Baja</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>

<?php
  $page = (int)($products['page'] ?? 1);
  $per = (int)($products['perPage'] ?? 15);
  $total = (int)($products['total'] ?? 0);
  $pages = (int)ceil($total / max(1,$per));
?>

@if($pages > 1)
  <div style="margin-top:12px;">
    @if($page > 1)
      <a href="{{ route('admin.products.index') }}?page={{ $page-1 }}">← Anterior</a>
    @endif
    <span style="margin:0 10px;">Página {{ $page }} de {{ $pages }}</span>
    @if($page < $pages)
      <a href="{{ route('admin.products.index') }}?page={{ $page+1 }}">Siguiente →</a>
    @endif
  </div>
@endif
@endsection
