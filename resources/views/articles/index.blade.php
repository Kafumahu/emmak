@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .page-content {
        padding: 15px 15px 100px 15px;
    }

    .article-card {
        border-radius: 15px;
        margin-bottom: 25px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .article-card-header {
        background: #c4908a;
        padding: 20px;
        text-align: center;
    }

    .article-card-header h2 {
        font-family: 'Lora', serif;
        font-weight: 700;
        font-size: 20px;
        color: #1a2a4a;
    }

    .article-card-body {
        padding: 15px 20px;
        background: #f5f5f5;
    }

    .article-description {
        font-size: 15px;
        color: #333;
    }

    .article-card-footer {
        background: #d6f5f5;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color: #1a6b6b;
    }

    .btn-lire {
        display: inline-block;
        padding: 6px 18px;
        background: #2a9d8f;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-lire:hover {
        background: #1a6b6b;
    }

    .publier-btn {
        display: block;
        text-align: center;
        margin: 0 auto 20px auto;
        padding: 12px 40px;
        background: #2a9d8f;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-size: 16px;
        width: fit-content;
    }

    .empty-state {
        text-align: center;
        color: #1a6b6b;
        margin-top: 60px;
        font-style: italic;
        font-size: 18px;
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

<div class="page-content">

    @auth
    <a href="{{ route('articles.create') }}" class="publier-btn">+ Publier un article</a>
    @endauth

    @forelse($articles as $article)
    <div class="article-card">
        <div class="article-card-header">
            <h2>{{ $article->titre }}</h2>
        </div>

        <div class="article-card-body">
            <p class="article-description">{{ $article->description }}</p>
        </div>

        <div class="article-card-footer">
            <span>{{ $article->created_at->format('d/m/Y') }}</span>
            <span>💬 {{ $article->commentaires->count() }}</span>
            <a href="{{ route('articles.show', $article) }}" class="btn-lire">Lire</a>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <p>Aucun article pour le moment.</p>
        <p>Sois le/la premier/première à publier ! </p>
    </div>
    @endforelse

    <div style="text-align:center; margin-top: 20px;">
        {{ $articles->links() }}
    </div>

</div>

<!-- Barre navigation bas -->
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