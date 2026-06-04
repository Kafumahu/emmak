@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .recherche-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px 15px 100px 15px;
    }

    .recherche-title {
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

    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }

    .search-input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid #2a9d8f;
        border-radius: 30px;
        font-family: 'Lora', serif;
        font-size: 15px;
        background: white;
        outline: none;
        color: #1a2a4a;
    }

    .search-input:focus {
        border-color: #1a6b6b;
    }

    .search-btn {
        padding: 14px 25px;
        background: #2a9d8f;
        color: white;
        border: none;
        border-radius: 30px;
        font-family: 'Lora', serif;
        font-size: 15px;
        cursor: pointer;
    }

    .search-btn:hover {
        background: #1a6b6b;
    }

    .section-title {
        font-size: 16px;
        color: #1a2a4a;
        font-weight: 700;
        margin-bottom: 15px;
        padding: 10px 15px;
        background: #d6f5f5;
        border-radius: 10px;
    }

    /* Cartes utilisateurs */
    .user-card {
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

    .user-card:hover {
        background: #f0fafa;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: #2a9d8f;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-info h3 {
        font-size: 16px;
        color: #1a2a4a;
        margin-bottom: 3px;
    }

    .user-info p {
        font-size: 13px;
        color: #888;
    }

    /* Cartes articles */
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

    /* Barre navigation bas */
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

<div class="recherche-container">
    <div class="recherche-title">🔍 Recherche</div>

    <form method="GET" action="{{ route('recherche.index') }}" class="search-form">
        <input
            type="text"
            name="q"
            class="search-input"
            placeholder="Rechercher un utilisateur ou article..."
            value="{{ $query ?? '' }}"
            autofocus
        >
        <button type="submit" class="search-btn">Chercher</button>
    </form>

    @if($query)

        {{-- Utilisateurs --}}
        @if($users->count() > 0)
        <div class="section-title">👤 Utilisateurs trouvés ({{ $users->count() }})</div>
        @foreach($users as $user)
        <a href="{{ route('profil.show', $user->id) }}" class="user-card">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div class="user-info">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->articles->count() }} article(s) publié(s)</p>
            </div>
        </a>
        @endforeach
        @endif

        {{-- Articles --}}
        @if($articles->count() > 0)
        <div class="section-title" style="margin-top:20px">📝 Articles trouvés ({{ $articles->count() }})</div>
        @foreach($articles as $article)
        <div class="article-card">
            <div class="article-card-header">
                <h2>{{ $article->titre }}</h2>
            </div>
            <div class="article-card-body">
                <p>{{ $article->description }}</p>
            </div>
            <div class="article-card-footer">
                <span>Par {{ $article->user->name }}</span>
                <span>{{ $article->created_at->format('d/m/Y') }}</span>
                <a href="{{ route('articles.show', $article) }}" class="btn-lire">Lire</a>
            </div>
        </div>
        @endforeach
        @endif

        @if($users->count() === 0 && $articles->count() === 0)
        <div class="empty-state">
            <p>Aucun résultat pour "{{ $query }}" 😕</p>
        </div>
        @endif

    @else
    <div class="empty-state">
        <p>Tape un nom ou un mot-clé pour rechercher ✨</p>
    </div>
    @endif

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