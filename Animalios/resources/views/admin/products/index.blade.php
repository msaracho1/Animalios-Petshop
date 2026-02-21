@extends('layouts.app')

@section('content')
<h1>Administrar Productos</h1>

@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

<a href="{{ route('admin.products.create') }}">+ Agregar producto</a>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Marca</th>
    <th>Subcategoría</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Acciones</th>
  </tr>

  @foreach($products as $p)
    <tr>
      <td>{{ $p->id_producto }}</td>
      <td>{{ $p->nombre }}</td>
      <td>{{ $p->brand?->nombre }}</td>
      <td>{{ $p->subcategory?->nombre }}</td>
      <td>${{ number_format($p->precio,2) }}</td>
      <td>{{ $p->stock }}</td>
      <td>
        <a href="{{ route('admin.products.edit', $p->id_producto) }}">Editar</a>

        <form method="POST" action="{{ route('admin.products.destroy', $p->id_producto) }}" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('¿Eliminar producto?')">Baja</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>

<div style="margin-top:12px;">
  {{ $products->links() }}
</div>
@endsection