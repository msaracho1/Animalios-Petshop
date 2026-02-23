@extends('layouts.app')

@section('content')
<h1>{{ $product->nombre }}</h1>

<p><strong>Marca:</strong> {{ $product->brand?->nombre }}</p>
<p><strong>Categoría:</strong> {{ $product->subcategory?->category?->nombre }}</p>
<p><strong>Subcategoría:</strong> {{ $product->subcategory?->nombre }}</p>
<p><strong>Precio:</strong> ${{ number_format($product->precio,2) }}</p>

@if($product->descripcion)
  <p>{{ $product->descripcion }}</p>
@endif

<form method="POST" action="{{ route('cart.add') }}">
  @csrf
  <input type="hidden" name="id_producto" value="{{ $product->id_producto }}">
  <label>Cantidad</label>
  <input type="number" name="cantidad" value="1" min="1" max="99">
  <button type="submit">Agregar al carrito</button>
</form>

<p style="margin-top:12px;"><a href="{{ route('store.index') }}">← Volver a la tienda</a></p>
@endsection
