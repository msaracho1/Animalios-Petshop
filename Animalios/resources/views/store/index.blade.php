<form method="POST" action="{{ route('cart.add') }}">
  @csrf
  <input type="hidden" name="id_producto" value="{{ $p->id_producto }}">
  <button type="submit">Agregar al carrito</button>
</form>