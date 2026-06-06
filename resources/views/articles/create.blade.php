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

    .media-preview img {
        width: 100%;
        border-radius: 10px;
        height: auto;
    }

    .media-preview video {
        width: 100%;
        border-radius: 10px;
        max-height: 300px;
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

    .error-msg {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    .photos-label {
        font-size: 14px;
        color: #1a2a4a;
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    .photo-slot {
        margin-bottom: 12px;
        background: white;
        border: 2px dashed #2a9d8f;
        border-radius: 10px;
        padding: 12px;
    }

    .photo-slot-title {
        font-size: 13px;
        color: #2a9d8f;
        margin-bottom: 8px;
        font-weight: 600;
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
            <input type="text" name="titre" class="form-input" placeholder="Titre de l'article" value="{{ old('titre') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Courte description</label>
            <input type="text" name="description" class="form-input" placeholder="Courte description de l'article" value="{{ old('description') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Contenu</label>
            <textarea name="contenu" class="form-textarea" placeholder="Écris ton article ici..." required>{{ old('contenu') }}</textarea>
        </div>

        {{-- 3 slots photos --}}
        <div class="form-group">
            <span class="photos-label">📷 Photos (optionnel — max 3)</span>

            <div class="photo-slot">
                <p class="photo-slot-title">Photo 1</p>
                <input type="file" name="image" class="form-file" accept="image/*" onchange="previewImage(event, 'preview-img1', 'image-preview1', 'image-error1')">
                <p class="file-hint">JPG, PNG, GIF — max 5MB</p>
                <p class="error-msg" id="image-error1">❌ L'image dépasse 5MB.</p>
                <div class="media-preview" id="image-preview1">
                    <img id="preview-img1" src="" alt="Aperçu 1">
                </div>
            </div>

            <div class="photo-slot">
                <p class="photo-slot-title">Photo 2</p>
                <input type="file" name="image2" class="form-file" accept="image/*" onchange="previewImage(event, 'preview-img2', 'image-preview2', 'image-error2')">
                <p class="file-hint">JPG, PNG, GIF — max 5MB</p>
                <p class="error-msg" id="image-error2">❌ L'image dépasse 5MB.</p>
                <div class="media-preview" id="image-preview2">
                    <img id="preview-img2" src="" alt="Aperçu 2">
                </div>
            </div>

            <div class="photo-slot">
                <p class="photo-slot-title">Photo 3</p>
                <input type="file" name="image3" class="form-file" accept="image/*" onchange="previewImage(event, 'preview-img3', 'image-preview3', 'image-error3')">
                <p class="file-hint">JPG, PNG, GIF — max 5MB</p>
                <p class="error-msg" id="image-error3">❌ L'image dépasse 5MB.</p>
                <div class="media-preview" id="image-preview3">
                    <img id="preview-img3" src="" alt="Aperçu 3">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">🎥 Vidéo (optionnel)</label>
            <input type="file" name="video" class="form-file" accept="video/*" onchange="previewVideo(event)">
            <p class="file-hint">MP4, MOV — max 150MB</p>
            <p class="error-msg" id="video-error">❌ La vidéo dépasse 150MB.</p>
            <div class="media-preview" id="video-preview">
                <video id="preview-video" controls></video>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">🏷️ Tags</label>
            <input type="text" name="tags" class="form-input" placeholder="mode, beauté, lifestyle..." value="{{ old('tags') }}">
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
    function previewImage(event, imgId, previewId, errorId) {
        const file = event.target.files[0];
        const errorEl = document.getElementById(errorId);
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                errorEl.style.display = 'block';
                event.target.value = '';
                document.getElementById(previewId).style.display = 'none';
                return;
            }
            errorEl.style.display = 'none';
            const preview = document.getElementById(previewId);
            const img = document.getElementById(imgId);
            img.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }

    function previewVideo(event) {
        const file = event.target.files[0];
        const errorEl = document.getElementById('video-error');
        if (file) {
            if (file.size > 150 * 1024 * 1024) {
                errorEl.style.display = 'block';
                event.target.value = '';
                document.getElementById('video-preview').style.display = 'none';
                return;
            }
            errorEl.style.display = 'none';
            const preview = document.getElementById('video-preview');
            const video = document.getElementById('preview-video');
            video.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

@endsection
