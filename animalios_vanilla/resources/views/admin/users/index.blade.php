@extends('layouts.app')

@section('content')
<h1>Administrar Usuarios</h1>

<a href="{{ route('admin.users.create') }}">+ Agregar usuario</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top:12px;">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Rol</th>
    <th>Acciones</th>
  </tr>

  @foreach($users['data'] as $u)
    <tr>
      <td>{{ $u->id_usuario }}</td>
      <td>{{ $u->nombre }}</td>
      <td>{{ $u->email }}</td>
      <td>{{ $u->role?->nombre }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $u->id_usuario) }}">Editar</a>

        <form method="POST" action="{{ route('admin.users.destroy', ['id'=>$u->id_usuario]) }}" style="display:inline">
          @csrf
          <button type="submit" onclick="return confirm('¿Dar de baja/eliminar usuario?')">Baja</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>

<?php
  $page = (int)($users['page'] ?? 1);
  $per = (int)($users['perPage'] ?? 15);
  $total = (int)($users['total'] ?? 0);
  $pages = (int)ceil($total / max(1,$per));
?>

@if($pages > 1)
  <div style="margin-top:12px;">
    @if($page > 1)
      <a href="{{ route('admin.users.index') }}?page={{ $page-1 }}">← Anterior</a>
    @endif
    <span style="margin:0 10px;">Página {{ $page }} de {{ $pages }}</span>
    @if($page < $pages)
      <a href="{{ route('admin.users.index') }}?page={{ $page+1 }}">Siguiente →</a>
    @endif
  </div>
@endif
@endsection
