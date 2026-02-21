@extends('layouts.app')

@section('content')
  <h1>Animalios</h1>

  <h2>Marcas</h2>
  <ul>
    @foreach($brands as $b)
      <li>{{ $b->nombre }}</li>
    @endforeach
  </ul>

  <h2>Productos destacados</h2>
  <ul>
    @foreach($featured as $p)
      <li>
        <a href="{{ route('store.show', $p->id_producto) }}">{{ $p->nombre }}</a>
        - ${{ $p->precio }}
      </li>
    @endforeach
  </ul>
@endsection