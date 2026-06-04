@extends('layout')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(180deg, #00e5e5 0%, #7df5ef 100%);
        min-height: 100vh;
    }

    .create-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px 15px 100px 15px;
    }

    .create-title {
        text-align: center;
        font-family: 'Lora', serif;
        font-size: 28px;
        color: #1a2a4a;
        margin-bottom: 25px;
        background: #c4908a;
        padding: 20px;
        border-radius: 15px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        color: #1a2a4a;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #2a9d8f;
        border-radius: 10px;
        font-family: 'Lora', serif;
        font-size: 15px;
        background: white;
        outline: none;
        color: #1a2a4a;
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-input:focus, .form-textarea:focus {
        border-color: #1a6b6b;
        box-shadow: 0 0 8px rgba(42,157,143,0.3);
    }

    .form-file {
        width: 100%;
        padding: 12px;
        background: white;
        border: 2px dashed #2a9d8f;
        border-radius: 10px;
        font-family: 'Lora', serif;
        font-size: 14px;
        color: #1a2a4a;
        cursor: pointer;
    }

    .file-hint {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }

    .tags-hint {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }

    .media-preview {
        margin-top: 10px;
        display: none;
    }

    .media-preview img, .media-preview video {
        width: 100%;
        border-radius: 10px;
        max-height: 200px;
        object-fit: cover;
    }

    .btn-publier {
        width: 100%;
        padding: 16px;
        background: #2a9d8f;
        color: white;
        border: none;
        border-radius: 30px;
        font-family: 'Lora', serif;
        font-size: 18px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s;
    }

    .btn-publier:hover {
        background: #1a6b6b;
    }

    .btn-annuler {
        display: block;
        text-align: center;
        margin-top: 15px;
        padding: 14px;
        border: 1.5px solid #ccc;
        border-radius: 30px;
        color: #555;
        text-decoration: none;
        font-size: 15px;
        background: white;
    }

    .btn-annuler:hover {
        background: #f0fafa;
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

<div class="create-container">
    <h2 class="create-title">Publier un article</h2>

    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Titre</label>
            <input
                type="text"
                name="titre"
                class="form-input"
                placeholder="Titre de l'article"
                value="{{ old('titre') }}"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">Courte description</label>
            <input
                type="text"
                name="description"
                class="form-input"
                placeholder="Courte description de l'article"
                value="{{ old('description') }}"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label">Contenu</label>
            <textarea
                name="contenu"
                class="form-textarea"
                placeholder="Écris ton article ici..."
                required
            >{{ old('contenu') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">📷 Photo (optionnel)</label>
            <input
                type="file"
                name="image"
                class="form-file"
                accept="image/*"
                onchange="previewImage(event)"
            >
            <p class="file-hint">JPG, PNG, GIF — max 5MB</p>
            <div class="media-preview" id="image-preview">
                <img id="preview-img" src="" alt="Aperçu">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">🎥 Vidéo (optionnel)</label>
            <input
                type="file"
                name="video"
                class="form-file"
                accept="video/*"
                onchange="previewVideo(event)"
            >
            <p class="file-hint">MP4, MOV — max 50MB</p>
            <div class="media-preview" id="video-preview">
                <video id="preview-video" controls></video>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">🏷️ Tags</label>
            <input
                type="text"
                name="tags"
                class="form-input"
                placeholder="mode, beauté, lifestyle..."
                value="{{ old('tags') }}"
            >
            <p class="tags-hint">Sépare les tags par des virgules</p>
        </div>

        <button type="submit" class="btn-publier">Publier</button>
    </form>

    <a href="{{ route('articles.index') }}" class="btn-annuler">Annuler</a>
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

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            img.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }

    function previewVideo(event) {
        const file = event.target.files[0];
        if (file) {
            const preview = document.getElementById('video-preview');
            const video = document.getElementById('preview-video');
            video.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

@endsection