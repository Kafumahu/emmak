@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .profil-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px 15px 100px 15px;
    }

    .profil-header {
        background: #c4908a;
        border-radius: 15px;
        padding: 25px 20px;
        text-align: center;
        margin-bottom: 25px;
    }

    .profil-avatar {
        width: 80px;
        height: 80px;
        background: #2a9d8f;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 36px;
        font-weight: 700;
        margin: 0 auto 15px auto;
    }

    .profil-name {
        font-family: 'Lora', serif;
        font-size: 24px;
        color: #1a2a4a;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .profil-stats {
        font-size: 14px;
        color: #555;
    }

    .articles-title {
        font-size: 16px;
        color: #1a2a4a;
        font-weight: 700;
        margin-bottom: 15px;
        padding: 10px 15px;
        background: #d6f5f5;
        border-radius: 10px;
    }

    .article-card {
        border-radius: 15px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }

    .article-card-header {
        background: #c4908a;
        padding: 15px 20px;
        text-align: center;
    }

    .article-card-header h2 {
        font-family: 'Lora', serif;
        font-weight: 700;
        font-size: 18px;
        color: #1a2a4a;
    }

    .article-card-body {
        padding: 12px 20px;
        background: #f5f5f5;
        font-size: 14px;
        color: #333;
    }

    .article-card-footer {
        background: #d6f5f5;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #1a6b6b;
    }

    .btn-lire {
        padding: 6px 18px;
        background: #2a9d8f;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 13px;
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

<div class="profil-container">

    <div class="profil-header">
        @if(auth()->id() === $user->id)
<div style="text-align:center; margin-bottom:20px">
    <a href="{{ route('articles.create') }}"
        style="display:inline-block; padding:10px 25px; background:#2a9d8f; color:white; border-radius:30px; text-decoration:none; font-size:14px; margin-right:10px;">
        + Publier
    </a>
    <a href="{{ route('notifications.index') }}"
        style="display:inline-block; padding:10px 25px; background:#c4908a; color:white; border-radius:30px; text-decoration:none; font-size:14px; margin-right:10px;">
        🔔 Notifications
    </a>
    <form method="POST" action="{{ route('deconnexion') }}" style="display:inline">
        @csrf
        <button type="submit"
            style="padding:10px 25px; background:white; color:#e74c3c; border:2px solid #e74c3c; border-radius:30px; font-family:'Lora',serif; font-size:14px; cursor:pointer;">
            Déconnexion
        </button>
    </form>
</div>
@endif
        <div class="profil-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h2 class="profil-name">{{ $user->name }}</h2>
        <p class="profil-stats">{{ $articles->total() }} article(s) publié(s)</p>
    </div>

    <div class="articles-title">📝 Articles publiés</div>

    @forelse($articles as $article)
<div class="article-card">
    <div class="article-card-header">
        <h2>{{ $article->titre }}</h2>
    </div>
    <div class="article-card-body">
        <p>{{ $article->description }}</p>
    </div>
    <div class="article-card-footer">
        <span>📅 {{ $article->created_at->format('d/m/Y') }}</span>
        <span>💬 {{ $article->commentaires->count() }}</span>
        <a href="{{ route('articles.show', $article) }}" class="btn-lire">Lire</a>
        @if(auth()->id() === $article->user_id)
        <form method="POST" action="{{ route('articles.destroy', $article) }}" style="display:inline"
            onsubmit="return confirm('Supprimer cet article ?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="padding:6px 15px; background:white; color:#e74c3c; border:2px solid #e74c3c; border-radius:20px; font-family:'Lora',serif; font-size:12px; cursor:pointer;">
                🗑 Supprimer
            </button>
        </form>
        @endif
    </div>
</div>
@empty
    <div class="empty-state">
        <p>Aucun article publié pour le moment ✨</p>
    </div>
    @endforelse

    <div style="text-align:center; margin-top:20px">
        {{ $articles->links() }}
    </div>

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