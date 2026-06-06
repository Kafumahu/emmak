@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .show-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 15px 15px 100px 15px;
    }

    .article-header {
        background: #c4908a;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        margin-bottom: 15px;
    }

    .article-header h1 {
        font-family: 'Lora', serif;
        font-size: 22px;
        color: #1a2a4a;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .article-meta {
        font-size: 13px;
        color: #555;
    }

    .article-contenu {
        background: #f5f5f5;
        border-radius: 10px;
        padding: 20px;
        font-size: 15px;
        line-height: 1.8;
        color: #333;
        margin-bottom: 15px;
    }

    .article-image {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 10px;
        height: auto;
        object-fit: unset;
    }

    .article-video {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 15px;
        max-height: 300px;
    }

    .article-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .tag {
        background: #2a9d8f;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .commentaires-section {
        background: #f5f5f5;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .commentaires-title {
        font-size: 18px;
        color: #1a6b6b;
        margin-bottom: 20px;
        border-bottom: 2px solid #d6f5f5;
        padding-bottom: 10px;
    }

    .commentaire {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 3px solid #2a9d8f;
    }

    .commentaire-reponse {
        background: #f0fafa;
        border-radius: 10px;
        padding: 12px;
        margin-top: 10px;
        margin-left: 20px;
        border-left: 3px solid #c4908a;
    }

    .commentaire-user {
        font-weight: 700;
        color: #1a6b6b;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .commentaire-contenu {
        font-size: 15px;
        color: #333;
        margin-bottom: 8px;
    }

    .mention {
        color: #2a9d8f;
        font-weight: 600;
    }

    .commentaire-meta {
        font-size: 12px;
        color: #888;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .commentaire-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .tag-small {
        background: #c4908a;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
    }

    .btn-repondre {
        background: none;
        border: none;
        color: #2a9d8f;
        cursor: pointer;
        font-size: 13px;
        font-family: 'Lora', serif;
        text-decoration: underline;
    }

    .btn-supprimer {
        background: none;
        border: none;
        color: #e74c3c;
        cursor: pointer;
        font-size: 13px;
        font-family: 'Lora', serif;
        text-decoration: underline;
    }

    .form-commentaire {
        background: #f5f5f5;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-commentaire h3 {
        font-size: 16px;
        color: #1a6b6b;
        margin-bottom: 15px;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #2a9d8f;
        border-radius: 10px;
        font-family: 'Lora', serif;
        font-size: 14px;
        background: white;
        outline: none;
        color: #1a2a4a;
        margin-bottom: 12px;
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .tags-hint {
        font-size: 11px;
        color: #888;
        margin-top: -8px;
        margin-bottom: 12px;
    }

    .mention-hint {
        font-size: 11px;
        color: #2a9d8f;
        margin-top: -8px;
        margin-bottom: 12px;
    }

    .btn-commenter {
        width: 100%;
        padding: 12px;
        background: #2a9d8f;
        color: white;
        border: none;
        border-radius: 30px;
        font-family: 'Lora', serif;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-commenter:hover {
        background: #1a6b6b;
    }

    .reponse-form {
        margin-top: 10px;
        display: none;
    }

    .reponse-form.active {
        display: block;
    }

    .login-prompt {
        text-align: center;
        padding: 20px;
        background: #f0fafa;
        border-radius: 15px;
        margin-bottom: 20px;
    }

    .login-prompt a {
        color: #2a9d8f;
        font-weight: 600;
    }

    .textarea-wrapper {
        position: relative;
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

<div class="show-container">

    {{-- Header article --}}
    <div class="article-header">
        <h1>{{ $article->titre }}</h1>
        <p class="article-meta">
            Par <strong>{{ $article->user->name }}</strong> —
            {{ $article->created_at->format('d/m/Y') }}
        </p>
    </div>

    {{-- Image principale avec bouton like --}}
    @if($article->image)
    <div style="position:relative; margin-bottom:10px">
        <img src="{{ asset('storage/' . $article->image) }}" class="article-image" alt="{{ $article->titre }}">
        @auth
        <button id="like-btn" onclick="toggleLike({{ $article->id }})"
            style="position:absolute; bottom:10px; right:10px;
            background:{{ $article->likes->where('user_id', auth()->id())->count() ? '#e74c3c' : 'rgba(255,255,255,0.9)' }};
            border: 2px solid #e74c3c;
            color:{{ $article->likes->where('user_id', auth()->id())->count() ? 'white' : '#e74c3c' }};
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Lora', serif;">
            ❤️ <span id="like-count">{{ $article->likes->count() }}</span>
        </button>
        @endauth
    </div>
    @endif

    {{-- Image 2 --}}
    @if($article->image2)
    <img src="{{ asset('storage/' . $article->image2) }}" class="article-image" alt="{{ $article->titre }}">
    @endif

    {{-- Image 3 --}}
    @if($article->image3)
    <img src="{{ asset('storage/' . $article->image3) }}" class="article-image" alt="{{ $article->titre }}" style="margin-bottom:15px">
    @endif

    {{-- Si pas d'image du tout, like flottant sous le header --}}
    @if(!$article->image)
    @auth
    <div style="text-align:right; margin-bottom:15px">
        <button id="like-btn" onclick="toggleLike({{ $article->id }})"
            style="background:{{ $article->likes->where('user_id', auth()->id())->count() ? '#e74c3c' : 'white' }};
            border: 2px solid #e74c3c;
            color:{{ $article->likes->where('user_id', auth()->id())->count() ? 'white' : '#e74c3c' }};
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Lora', serif;">
            ❤️ <span id="like-count">{{ $article->likes->count() }}</span>
        </button>
    </div>
    @endauth
    @endif

    {{-- Vidéo --}}
    @if($article->video)
    <video class="article-video" controls>
        <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
    </video>
    @endif

    {{-- Contenu --}}
    <div class="article-contenu">
        {!! nl2br(e($article->contenu)) !!}
    </div>

    {{-- Tags --}}
    @if($article->tags->count() > 0)
    <div class="article-tags">
        @foreach($article->tags as $tag)
            <span class="tag"># {{ $tag->nom }}</span>
        @endforeach
    </div>
    @endif

    {{-- Commentaires --}}
    <div class="commentaires-section">
        <h2 class="commentaires-title">
            💬 {{ $article->commentaires->count() }} Commentaire(s)
        </h2>

        @foreach($article->commentaires->whereNull('parent_id') as $commentaire)
        <div class="commentaire">
            <p class="commentaire-user">{{ $commentaire->user->name }}</p>
            <p class="commentaire-contenu">
                @php
                    $contenu = e($commentaire->contenu);
                    $contenu = preg_replace('/@(\w+)/', '<span class="mention">@$1</span>', $contenu);
                @endphp
                {!! $contenu !!}
            </p>

            @if($commentaire->tags->count() > 0)
            <div class="commentaire-tags">
                @foreach($commentaire->tags as $tag)
                    <span class="tag-small"># {{ $tag->nom }}</span>
                @endforeach
            </div>
            @endif

            <div class="commentaire-meta">
                <span>{{ $commentaire->created_at->format('d/m/Y H:i') }}</span>

                @auth
                <button class="btn-repondre" onclick="toggleReponse('reponse-{{ $commentaire->id }}')">
                    Répondre
                </button>
                @endauth

                @auth
                @if(auth()->id() === $commentaire->user_id)
                <form method="POST" action="{{ route('commentaires.destroy', $commentaire) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-supprimer">Supprimer</button>
                </form>
                @endif
                @endauth
            </div>

            {{-- Formulaire réponse --}}
            @auth
            <div class="reponse-form" id="reponse-{{ $commentaire->id }}">
                <form method="POST" action="{{ route('commentaires.store', $article->id) }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $commentaire->id }}">
                    <div class="textarea-wrapper">
                        <textarea
                            name="contenu"
                            class="form-textarea"
                            placeholder="Répondre... utilisez @nom pour mentionner quelqu'un"
                            style="min-height:70px"
                            required
                        ></textarea>
                    </div>
                    <p class="mention-hint">💡 Utilise @nom pour mentionner quelqu'un</p>
                    <button type="submit" class="btn-commenter">Répondre</button>
                </form>
            </div>
            @endauth

            {{-- Réponses --}}
            @foreach($commentaire->reponses as $reponse)
            <div class="commentaire-reponse">
                <p class="commentaire-user">↩ {{ $reponse->user->name }}</p>
                <p class="commentaire-contenu">
                    @php
                        $contenuRep = e($reponse->contenu);
                        $contenuRep = preg_replace('/@(\w+)/', '<span class="mention">@$1</span>', $contenuRep);
                    @endphp
                    {!! $contenuRep !!}
                </p>
                <div class="commentaire-meta">
                    <span>{{ $reponse->created_at->format('d/m/Y H:i') }}</span>
                    @auth
                    @if(auth()->id() === $reponse->user_id)
                    <form method="POST" action="{{ route('commentaires.destroy', $reponse) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-supprimer">Supprimer</button>
                    </form>
                    @endif
                    @endauth
                </div>
            </div>
            @endforeach

        </div>
        @endforeach
    </div>

    {{-- Formulaire nouveau commentaire --}}
    @auth
    <div class="form-commentaire">
        <h3>💬 Laisser un commentaire</h3>
        <form method="POST" action="{{ route('commentaires.store', $article->id) }}">
            @csrf
            <div class="textarea-wrapper">
                <textarea
                    name="contenu"
                    class="form-textarea"
                    placeholder="Écris ton commentaire... utilise @nom pour mentionner quelqu'un"
                    required
                ></textarea>
            </div>
            <p class="mention-hint">💡 Utilise @nom pour mentionner quelqu'un</p>
            <input
                type="text"
                name="tags"
                class="form-input"
                placeholder="Tags : mode, beauté... (optionnel)"
            >
            <p class="tags-hint">Sépare les tags par des virgules</p>
            <button type="submit" class="btn-commenter">Commenter</button>
        </form>
    </div>
    @else
    <div class="login-prompt">
        <p><a href="{{ route('connexion') }}">Connecte-toi</a> pour laisser un commentaire.</p>
    </div>
    @endauth

</div>

{{-- Bottom nav --}}
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

<script>
    function toggleReponse(id) {
        const el = document.getElementById(id);
        el.classList.toggle('active');
    }

    function toggleLike(articleId) {
        fetch(`/articles/${articleId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            const btn = document.getElementById('like-btn');
            document.getElementById('like-count').textContent = data.total;
            if (data.liked) {
                btn.style.background = '#e74c3c';
                btn.style.color = 'white';
            } else {
                btn.style.background = 'white';
                btn.style.color = '#e74c3c';
            }
        });
    }
</script>

@endsection
