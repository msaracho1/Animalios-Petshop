@extends('layouts.app')

@section('content')
<h1>Agregar usuario</h1>

<form method="POST" action="{{ route('admin.users.store') }}">
  @csrf

  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre') }}"><br><br>

  <label>Email</label><br>
  <input name="email" type="email" value="{{ old('email') }}"><br><br>

  <label>Contraseña</label><br>
  <input name="contraseña" type="password"><br><br>

  <label>Rol</label><br>
  <select name="id_rol">
    @foreach($roles as $r)
      <option value="{{ $r->id_rol }}">{{ $r->nombre }}</option>
    @endforeach
  </select><br><br>

  <button type="submit">Guardar</button>
</form>
@endsection