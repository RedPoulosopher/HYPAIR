@vite(['resources/css/login.css'])
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="icon" type="image/png" href="/logo.png">
</head>
<body>
    <form action="/login" method="POST">
        @csrf
        <h1>OCANORD 590</h1>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <button type="submit">
                Se connecter
            </button>
        </div>
        @auth()
            <div>
                <a href="/dashboard">
                    {{ $user->email }}
                </a>
            </div>
        @endauth
        <a href="/register">Register</a>
    </form>
</body>
</html>

