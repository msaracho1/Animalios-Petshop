@extends('layouts.app')

@section('content')
<h1>Registro</h1>

@if(session('error'))
  <p style="color:red">{{ session('error') }}</p>
@endif
@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('register.post') }}">
  @csrf

  <label>Nombre</label><br>
  <input name="nombre" value="{{ old('nombre') }}"><br><br>

  <label>Email</label><br>
  <input type="email" name="email" value="{{ old('email') }}"><br><br>

  <label>Contraseña</label><br>
  <input type="password" name="contraseña"><br><br>

  <button type="submit">Registrarme</button>
</form>

<p>¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
@endsection