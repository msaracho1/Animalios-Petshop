<nav>
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('store.index') }}">Tienda</a>
  <a href="{{ route('about') }}">Nosotros</a>

  <a href="{{ route('cart.index') }}">Carrito</a>

  @auth
    <a href="{{ route('orders.index') }}">Historial de pedidos</a>

    @if(auth()->user()->role?->nombre === 'admin')
@if(auth()->user()->role?->nombre === 'admin')

  <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a>
  <a href="{{ route('admin.products.index') }}">Administrar Productos</a>
  <a href="{{ route('admin.orders.index') }}">Administrar Pedidos</a>

@endif
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