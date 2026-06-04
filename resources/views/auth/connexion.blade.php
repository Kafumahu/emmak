@extends('layout')

@section('content')
<style>
    .auth-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 20px;
    }

    .auth-title {
        text-align: center;
        font-family: 'Lora', serif;
        font-style: italic;
        font-size: 32px;
        color: #1a6b6b;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-input {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #2a9d8f;
        border-radius: 10px;
        font-family: 'Lora', serif;
        font-style: italic;
        font-size: 15px;
        background: white;
        outline: none;
        color: #1a2a4a;
    }

    .form-input:focus {
        border-color: #1a6b6b;
        box-shadow: 0 0 8px rgba(42,157,143,0.3);
    }

    .btn-connecter {
        width: 100%;
        padding: 16px;
        background: #2a9d8f;
        color: white;
        border: none;
        border-radius: 30px;
        font-family: 'Lora', serif;
        font-style: italic;
        font-size: 18px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s;
    }

    .btn-connecter:hover {
        background: #1a6b6b;
    }

    .auth-link {
        display: block;
        text-align: center;
        margin-top: 15px;
        padding: 14px;
        border: 1.5px solid #ccc;
        border-radius: 30px;
        color: #2a9d8f;
        text-decoration: none;
        font-size: 15px;
    }

    .auth-link:hover {
        background: #f0fafa;
    }
</style>

<div class="auth-container">
    <h2 class="auth-title">Connexion</h2>

    <form method="POST" action="{{ route('connexion') }}">
        @csrf

        <div class="form-group">
            <input
                type="email"
                name="email"
                class="form-input"
                placeholder="Email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="form-group">
            <input
                type="password"
                name="password"
                class="form-input"
                placeholder="Mot de passe"
                required
            >
        </div>

        <button type="submit" class="btn-connecter">Se connecter</button>
    </form>

    <a href="#" class="auth-link">Mot de passe oublié ?</a>

    <a href="{{ route('inscription') }}" class="auth-link">
        Pas encore de compte ? S'inscrire
    </a>
</div>
@endsection