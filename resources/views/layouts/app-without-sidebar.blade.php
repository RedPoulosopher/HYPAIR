<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>@yield('title', 'Site Web') - HypAIR</title>
        <link
            rel="stylesheet"
            href="css/accueil.css"
            type="text/css"
        />
    </head>
    
@include('layouts.theme')

    <body>

        @php
            // Code pour gérer le login utilisateur
            use App\Services\GestionPhotoDeProfil;
            if (Auth::check()) {
                $user = Auth::user();
                $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
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

        </div>
        
        <footer>
            Fait avec amour par l’AIR - Tous droits réservés
        </footer>
    </body>
    
</html>
