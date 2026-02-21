@extends('layouts.app')

@section('content')
<h1>Editar usuario #{{ $user->id_usuario }}</h1>

<form method="POST" action="{{ route('admin.users.update', $user->id_usuario) }}">
  @csrf
  @method('PUT')

  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre', $user->nombre) }}"><br><br>

  <label>Email</label><br>
  <input name="email" type="email" value="{{ old('email', $user->email) }}"><br><br>

  <label>Rol</label><br>
  <select name="id_rol">
    @foreach($roles as $r)
      <option value="{{ $r->id_rol }}" @selected($r->id_rol == $user->id_rol)>
        {{ $r->nombre }}
      </option>
    @endforeach
  </select><br><br>

  <label>Nueva contraseña (opcional)</label><br>
  <input name="contraseña" type="password"><br><br>

  <button type="submit">Actualizar</button>
</form>
@endsection