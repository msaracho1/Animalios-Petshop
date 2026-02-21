@extends('layouts.app')

@section('content')
<h1>Administrar Usuarios</h1>

@if(session('success'))
  <p style="color:green">{{ session('success') }}</p>
@endif
@if(session('error'))
  <p style="color:red">{{ session('error') }}</p>
@endif

<a href="{{ route('admin.users.create') }}">+ Agregar usuario</a>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Rol</th>
    <th>Acciones</th>
  </tr>

  @foreach($users as $u)
    <tr>
      <td>{{ $u->id_usuario }}</td>
      <td>{{ $u->nombre }}</td>
      <td>{{ $u->email }}</td>
      <td>{{ $u->role?->nombre }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $u->id_usuario) }}">Editar</a>

        <form method="POST" action="{{ route('admin.users.destroy', $u->id_usuario) }}" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('¿Dar de baja/eliminar usuario?')">Baja</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>

<div style="margin-top:12px;">
  {{ $users->links() }}
</div>
@endsection