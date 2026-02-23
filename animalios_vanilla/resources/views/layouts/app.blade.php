<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Animalios' }}</title>
  <style>
    body{font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif; margin:24px;}
    nav a{margin-right:12px;}
    .flash{padding:10px 12px; border-radius:8px; margin:12px 0;}
    .flash.success{background:#e9fbe9;}
    .flash.error{background:#ffe9e9;}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('store.index') }}">Tienda</a>
  <a href="{{ route('about') }}">Nosotros</a>
  <a href="{{ route('cart.index') }}">Carrito</a>

  @auth
    <a href="{{ route('orders.index') }}">Mis pedidos</a>

    @if(auth()->user()->role?->nombre === 'admin')
      <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a>
      <a href="{{ route('admin.products.index') }}">Administrar Productos</a>
      <a href="{{ route('admin.orders.index') }}">Administrar Pedidos</a>
    @endif

    <form method="POST" action="{{ route('logout') }}" style="display:inline">
      @csrf
      <button type="submit">Cerrar sesión</button>
    </form>
  @else
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Registro</a>
  @endauth
</nav>

@if(session('success'))
  <div class="flash success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="flash error">{{ session('error') }}</div>
@endif

<hr>

@yield('content')

</body>
</html>
