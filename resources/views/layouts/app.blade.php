<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('titre', 'Site Web') - HypAIR</title>

    <link rel="stylesheet" href="/css/default.css" type="text/css" />
    @stack('styles')
</head>

@include('layouts.theme')

<body>

    @php
        // Code pour gérer le login utilisateur
        use App\Services\GestionPhotoDeProfil;
        if (Auth::check()) {
            $user = Auth::user();
            $user['chemin_photo_de_profil'] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
        }
    @endphp

    <!-- Barre de navigation -->
    <!-- Si l'utilisateur est connecté : faire apparaître sa PFP au lieu du bouton Se Connecter -->
    @if (Auth::check())
        <x-navbar :isConnected="true" :user="$user" />

        <!-- Sinon : mettre le bouton Se Connecter (la navbar normale) -->
    @else
        <x-navbar :isConnected="false" :user="[]" />
    @endif

    <!-- Contenu de la page -->
    <div id="content">

        @yield('content')

        <!-- Side bar : planning de la semaine -->
        <aside id="side-bar">

            <div id="calendrier-sidebar">
                <h1>Cette semaine</h1>
                @php
                    // Données de test fictives
                    $comingEvents = [['Tournoi de Smash Bros', 'Samedi 18 Septembre'], ['Conférence IMTalks', 'Dimanche 19 Septembre'], ['Reveal Gala', 'Mardi 21 Septembre'], ['Soirée Bourse', 'Jeudi 23 Septembre']];
                @endphp

                @foreach ($comingEvents as $comingEvent)
                    <x-coming-event :title="$comingEvent[0]" :date="$comingEvent[1]" />
                @endforeach

            </div>
        </aside>
        <footer>
            <a href="/a-propos">Fait avec amour par l’AIR - Tous droits réservés</a>
        </footer>
    </div>

</body>

</html>
