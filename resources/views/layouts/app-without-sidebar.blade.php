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
        <!-- Barre de navigation -->
        <x-navbar/>

        <!-- Contenu de la page -->
        <div id="content">
            
            @yield('content')

        </div>
        
        <footer>
            Fait avec amour par l’AIR - Tous droits réservés
        </footer>
    </body>
    
</html>
