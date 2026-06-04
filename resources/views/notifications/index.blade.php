@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .notif-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px 15px 100px 15px;
    }

    .notif-title {
        background: #c4908a;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        font-family: 'Lora', serif;
        font-size: 22px;
        color: #1a2a4a;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .notif-card {
        background: white;
        border-radius: 15px;
        padding: 15px 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        text-decoration: none;
    }

    .notif-card.non-lu {
        border-left: 4px solid #2a9d8f;
        background: #f0fafa;
    }

    .notif-avatar {
        width: 45px;
        height: 45px;
        background: #2a9d8f;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .notif-info p {
        font-size: 14px;
        color: #333;
        margin-bottom: 4px;
    }

    .notif-info span {
        font-size: 12px;
        color: #888;
    }

    .notif-icon {
        font-size: 22px;
        flex-shrink: 0;
    }

    .empty-state {
        text-align: center;
        color: #1a6b6b;
        margin-top: 40px;
        font-style: italic;
        font-size: 16px;
        background: white;
        padding: 30px;
        border-radius: 15px;
    }

    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #2a9d8f;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 10px 0;
        z-index: 100;
    }

    .bottom-nav a {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bottom-nav img {
        width: 45px;
        height: 45px;
        object-fit: contain;
    }
</style>

<div class="notif-container">
    <div class="notif-title">🔔 Notifications</div>

    @forelse($notifications as $notif)
    <a href="{{ route('articles.show', $notif->article_id) }}" class="notif-card {{ $notif->lu ? '' : 'non-lu' }}">
        <div class="notif-avatar">
            {{ strtoupper(substr($notif->fromUser->name, 0, 1)) }}
        </div>
        <div class="notif-info">
            @if($notif->type === 'like')
            <p><strong>{{ $notif->fromUser->name }}</strong> a aimé votre article ❤️</p>
            @elseif($notif->type === 'commentaire')
            <p><strong>{{ $notif->fromUser->name }}</strong> a commenté votre article 💬</p>
            @endif
            <p style="color:#888;font-size:13px">{{ $notif->article->titre }}</p>
            <span>{{ $notif->created_at->diffForHumans() }}</span>
        </div>
        <div class="notif-icon">
            @if($notif->type === 'like') ❤️ @else 💬 @endif
        </div>
    </a>
    @empty
    <div class="empty-state">
        <p>Aucune notification pour le moment 🔔</p>
    </div>
    @endforelse
</div>

<div class="bottom-nav">
    <a href="{{ route('articles.index') }}">
        <img src="{{ asset('images/home.jpeg') }}" alt="Accueil">
    </a>
    <a href="{{ route('recherche.index') }}">
        <img src="{{ asset('images/search.jpeg') }}" alt="Recherche">
    </a>
    <a href="{{ auth()->check() ? route('profil.moi') : route('connexion') }}">
        <img src="{{ asset('images/profil.jpeg') }}" alt="Profil">
    </a>
</div>

@endsection