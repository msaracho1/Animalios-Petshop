@extends('layouts.app')

@section('content')
<h1>Ingresar</h1>

@if(session('error'))
  <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('login.post') }}">
  @csrf

  <label>Email</label><br>
  <input type="email" name="email" value="{{ old('email') }}"><br><br>

  <label>Contraseña</label><br>
  <input type="password" name="contraseña"><br><br>

  <button type="submit">Ingresar</button>
</form>

<p>¿No tenés cuenta? <a href="{{ route('register') }}">Registrate</a></p>
@endsection