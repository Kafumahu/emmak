<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmmaK - Le Blog</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lora', serif;
            background: #e0fafa;
            min-height: 100vh;
        }

        .navbar {
            background: #00e5e5;
            padding: 12px 20px;
            display: flex;
            align-items: center;
        }

        .navbar .logo {
            font-family: 'Dancing Script', cursive;
            font-size: 28px;
            color: #1a2a4a;
            text-decoration: none;
        }

        .content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-family: 'Lora', serif;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: #2a9d8f;
            color: white;
        }

        .btn-gold {
            background: transparent;
            border: 2px solid #c9a84c;
            color: #1a2a4a;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('accueil') }}" class="logo">EmmaK</a>
    </nav>

    <div class="content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>