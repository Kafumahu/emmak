<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmmaK - Le Blog</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lora', serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Navbar */
        .navbar {
            background: #00e5e5;
            padding: 10px 15px;
            height: 55px;
            display: flex;
            align-items: center;
        }

        .navbar .logo {
            font-family: 'Dancing Script', cursive;
            font-size: 30px;
            color: #1a2a4a;
            text-decoration: none;
        }

        /* Zone image principale */
        .hero-image {
            width: 100%;
            height: calc(100vh - 55px - 110px);
            display: block;
            object-fit: cover;
            object-position: center;
        }

        /* Barre du bas */
        .bottom-bar {
            height: 110px;
            background: #2a9d8f;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-gold {
            padding: 14px 35px;
            border-radius: 30px;
            border: 2.5px solid #c9a84c;
            background: transparent;
            color: #1a2a4a;
            font-family: 'Lora', serif;
            font-size: 16px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: #c9a84c;
            color: white;
        }

        .noeud {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .tagline {
            text-align: center;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.75);
            font-family: 'Lora', serif;
            font-style: italic;
            font-size: 17px;
            color: #1a2a4a;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('accueil') }}" class="logo">EmmaK</a>
    </nav>

    <!-- Phrase de présentation -->
    <div class="tagline">
        Un espace pour partager vos passions, vos idées et vos histoires.
    </div>

    <!-- Image principale -->
    <img src="{{ asset('images/fleur.jpeg') }}" alt="Le blog EmmaK" class="hero-image">

    <!-- Boutons bas -->
    <div class="bottom-bar">
        <a href="{{ route('inscription') }}" class="btn-gold">Inscription</a>
        <img src="{{ asset('images/noeud.jpeg') }}" alt="Nœud" class="noeud">
        <a href="{{ route('connexion') }}" class="btn-gold">Connexion</a>
    </div>

</body>
</html>
