@extends('layout')

@section('content')
<style>
    .articles-container {
        max-width: 700px;
        margin: 30px auto;
        padding: 10px;
    }

    .article-card {
        background: white;
        border-radius: 15px;
        margin-bottom: 30px;
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
        background: #f9f9f9;
    }

    .article-description {
        font-size: 15px;
        color: #333;
        margin-bottom: 10px;
    }

    .article-card-footer {
        background: #d6f5f5;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color: #1a6b6b;
    }

    .article-tags {
        padding: 10px 20px;
        background: #f9f9f9;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag {
        background: #2a9d8f;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .btn-lire {
        display: inline-block;
        padding: 8px 20px;
        background: #2a9d8f;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 13px;
        transition: background 0.3s;
    }

    .btn-lire:hover {
        background: #1a6b6b;
    }

    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #2a9d8f;
        display: flex;
        justify-content: space-around;
        padding: 12px 0;
        z-index: 100;
    }

    .bottom-nav a {
        color: white;
        text-decoration: none;
        font-size: 22px;
    }

    .page-content {
        padding-bottom: 80px;
    }

    .publier-btn {
        display: block;
        text-align: center;
        margin: 0 auto 25px auto;
        padding: 12px 40px;
        background: #2a9d8f;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-size: 16px;
        width: fit-content;
        transition: background 0.3s;
    }

    .publier-btn:hover {
        background: #1a6b6b;
    }

    .empty-state {
        text-align: center;
        color: #1a6b6b;
        margin-top: 60px;
        font-style: italic;
        font-size: 18px;
    }
</style>

<div class="page-content">
    <div class="articles-container">

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

            @if($article->tags->count() > 0)
            <div class="article-tags">
                @foreach($article->tags as $tag)
                    <span class="tag"># {{ $tag->nom }}</span>
                @endforeach
            </div>
            @endif

            <div class="article-card-footer">
                <span>📅 {{ $article->created_at->format('d/m/Y') }}</span>
                <span>💬 {{ $article->commentaires->count() }} commentaire(s)</span>
                <a href="{{ route('articles.show', $article) }}" class="btn-lire">Lire</a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>Aucun article pour le moment.</p>
            <p>Sois le premier à publier ! ✨</p>
        </div>
        @endforelse

        <div style="text-align:center; margin-top: 20px;">
            {{ $articles->links() }}
        </div>

    </div>
</div>

<div class="bottom-nav">
    <a href="{{ route('articles.index') }}" title="Accueil">🏠</a>
    <a href="#" title="Rechercher">🔍</a>
    @auth
    <a href="{{ route('articles.create') }}" title="Publier">✏️</a>
    @endauth
</div>

@endsection