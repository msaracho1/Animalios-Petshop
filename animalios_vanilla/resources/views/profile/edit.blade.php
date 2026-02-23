@extends('layouts.app')

@section('content')
<h1>Mi Perfil</h1>

@if(session('error'))
  <p style="color:red">{{ session('error') }}</p>
@endif
@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

<h3>Datos</h3>
<form method="POST" action="{{ route('profile.update') }}">
  @csrf
  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre', $user->nombre) }}"><br><br>

  <label>Email</label><br>
  <input type="email" name="email" value="{{ old('email', $user->email) }}"><br><br>

  <button type="submit">Guardar cambios</button>
</form>

<hr>

<h3>Cambiar contraseña</h3>
<form method="POST" action="{{ route('profile.password') }}">
  @csrf
  <label>Nueva contraseña</label><br>
  <input type="password" name="contraseña"><br><br>

  <button type="submit">Actualizar contraseña</button>
</form>
@endsection