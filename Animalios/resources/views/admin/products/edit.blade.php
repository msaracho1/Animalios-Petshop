@extends('layouts.app')

@section('content')
<h1>Editar producto #{{ $product->id_producto }}</h1>

<form method="POST" action="{{ route('admin.products.update', $product->id_producto) }}">
  @csrf
  @method('PUT')

  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre', $product->nombre) }}"><br><br>

  <label>Descripción</label><br>
  <textarea name="descripcion">{{ old('descripcion', $product->descripcion) }}</textarea><br><br>

  <label>Precio</label><br>
  <input type="number" step="0.01" name="precio" value="{{ old('precio', $product->precio) }}"><br><br>

  <label>Stock</label><br>
  <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"><br><br>

  <label>Marca</label><br>
  <select name="id_marca">
    @foreach($brands as $b)
      <option value="{{ $b->id_marca }}" @selected($b->id_marca == $product->id_marca)>
        {{ $b->nombre }}
      </option>
    @endforeach
  </select><br><br>

  <label>Subcategoría</label><br>
  <select name="id_subcategoria">
    @foreach($subcategories as $s)
      <option value="{{ $s->id_subcategoria }}" @selected($s->id_subcategoria == $product->id_subcategoria)>
        {{ $s->nombre }}
      </option>
    @endforeach
  </select><br><br>

  <button type="submit">Actualizar</button>
</form>
@endsection