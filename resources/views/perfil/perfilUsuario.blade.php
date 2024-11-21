@extends('layouts.app')

@section('title', 'Perfil de Usuarios ')

@section('content')

<div class="container mt-1">
    <div class="profile-card">
        <div class="profile-circle">{{ strtoupper(substr($usuario->name, 0, 2)) }}</div>
        <h4>{{$usuario->name}}</h4>
        <h5><i class="bi bi-envelope"></i>{{$usuario->email}}</h5>
        <h5><i class="bi bi-person"></i> {{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}</h5>
        <button class="btn btn-message">Mensaje</button>
    </div>
</div>
@endsection