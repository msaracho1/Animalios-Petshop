<form method="POST" action="{{ route('cart.add') }}">
  @csrf
  <input type="hidden" name="id_producto" value="{{ $product->id_producto }}">
  <input type="number" name="cantidad" value="1" min="1" max="99">
  <button type="submit">Agregar al carrito</button>
</form>