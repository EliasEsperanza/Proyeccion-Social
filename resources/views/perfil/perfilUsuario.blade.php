@extends('layouts.app')

@section('title', 'Perfil de Usuarios')

@section('content')

<style>
    .profile-card {
        background: linear-gradient(135deg, #ffe5e5, #f8f9fa);
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        padding: 3rem;
        max-width: 500px;
        margin: auto;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-circle {
        background: linear-gradient(135deg, #800000, #5a0000);
        color: #fff;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .profile-circle:hover {
        transform: rotate(10deg) scale(1.1);
    }

    .profile-card h4 {
        font-size: 2rem;
        font-weight: bold;
        margin: 1rem 0;
        color: #333;
    }

    .profile-card h5 {
        font-size: 1.2rem;
        color: #555;
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-card h5 i {
        margin-right: 0.5rem;
        color: #800000;
    }

    .btn-message {
        background: linear-gradient(135deg, #800000, #d40000);
        color: #fff;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 1.5rem;
        cursor: pointer;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-message:hover {
        background: linear-gradient(135deg, #d40000, #800000);
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: #fff;
    }

    .btn-message:active {
        transform: translateY(2px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="container">
    <div class="profile-card">
        <div class="profile-circle">{{ strtoupper(substr($usuario->name, 0, 2)) }}</div>
        <h4>{{ $usuario->name }}</h4>
        <h5><i class="bi bi-envelope"></i> {{ $usuario->email }}</h5>
        <h5><i class="bi bi-person"></i> {{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}</h5>
        <button class="btn btn-message">Enviar Mensaje</button>
    </div>
</div>

@endsection
