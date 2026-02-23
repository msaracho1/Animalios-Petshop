@extends('layouts.app')

@section('content')
<h1>Tienda</h1>

<form method="GET" action="{{ route('store.index') }}" style="margin-bottom:16px;">
  <input type="text" name="q" placeholder="Buscar" value="{{ $filters['q'] ?? '' }}">

  <select name="id_categoria">
    <option value="">Categoría (todas)</option>
    @foreach($categories as $c)
      <option value="{{ $c->id_categoria }}" @selected(($filters['id_categoria'] ?? '') == $c->id_categoria)>{{ $c->nombre }}</option>
    @endforeach
  </select>

  <select name="id_subcategoria">
    <option value="">Subcategoría (todas)</option>
    @foreach($subcategories as $s)
      <option value="{{ $s->id_subcategoria }}" @selected(($filters['id_subcategoria'] ?? '') == $s->id_subcategoria)>{{ $s->nombre }}</option>
    @endforeach
  </select>

  <select name="id_marca">
    <option value="">Marca (todas)</option>
    @foreach($brands as $b)
      <option value="{{ $b->id_marca }}" @selected(($filters['id_marca'] ?? '') == $b->id_marca)>{{ $b->nombre }}</option>
    @endforeach
  </select>

  <button type="submit">Filtrar</button>
</form>

@if(empty($products['data']))
  <p>No hay productos para mostrar.</p>
@else
  <table border="1" cellpadding="8" cellspacing="0">
    <tr>
      <th>Producto</th>
      <th>Marca</th>
      <th>Precio</th>
      <th></th>
    </tr>
    @foreach($products['data'] as $p)
      <tr>
        <td>
          <a href="{{ route('store.show', $p->id_producto) }}">{{ $p->nombre }}</a>
        </td>
        <td>{{ $p->brand?->nombre }}</td>
        <td>${{ number_format($p->precio,2) }}</td>
        <td>
          <form method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="id_producto" value="{{ $p->id_producto }}">
            <input type="hidden" name="cantidad" value="1">
            <button type="submit">Agregar</button>
          </form>
        </td>
      </tr>
    @endforeach
  </table>

  <?php
    $page = (int)($products['page'] ?? 1);
    $per = (int)($products['perPage'] ?? 12);
    $total = (int)($products['total'] ?? 0);
    $pages = (int)ceil($total / max(1,$per));
  ?>

  @if($pages > 1)
    <div style="margin-top:12px;">
      @if($page > 1)
        <a href="{{ route('store.index') }}?{{ http_build_query(array_merge($filters, ['page'=>$page-1])) }}">← Anterior</a>
      @endif
      <span style="margin:0 10px;">Página {{ $page }} de {{ $pages }}</span>
      @if($page < $pages)
        <a href="{{ route('store.index') }}?{{ http_build_query(array_merge($filters, ['page'=>$page+1])) }}">Siguiente →</a>
      @endif
    </div>
  @endif
@endif
@endsection
