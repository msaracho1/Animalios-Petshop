@extends('layouts.app')

@section('content')
<h1>Agregar producto</h1>

<form method="POST" action="{{ route('admin.products.store') }}">
  @csrf

  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre') }}"><br><br>

  <label>Descripción</label><br>
  <textarea name="descripcion">{{ old('descripcion') }}</textarea><br><br>

  <label>Precio</label><br>
  <input type="number" step="0.01" name="precio" value="{{ old('precio', 0) }}"><br><br>

  <label>Stock</label><br>
  <input type="number" name="stock" value="{{ old('stock', 0) }}"><br><br>

  <label>Marca</label><br>
  <select name="id_marca">
    @foreach($brands as $b)
      <option value="{{ $b->id_marca }}">{{ $b->nombre }}</option>
    @endforeach
  </select><br><br>

  <label>Subcategoría</label><br>
  <select name="id_subcategoria">
    @foreach($subcategories as $s)
      <option value="{{ $s->id_subcategoria }}">{{ $s->nombre }}</option>
    @endforeach
  </select><br><br>

  <button type="submit">Guardar</button>
</form>
@endsection