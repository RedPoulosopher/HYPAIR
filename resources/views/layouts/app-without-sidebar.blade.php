<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="HypAIR est le site associatif de l'IMT Nord Europe développé par l'AIR. Il regroupe l'ensemble des informations dont vous avez besoin en tant qu'étudiant !" />
    <title>@yield('titre', 'Site Web') - HypAIR</title>

    @include('pwa.meta')

    <link rel="stylesheet" href="{{ mix('/css/default.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/importants/layout-without-sidebar.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/select-promo-campus-popup.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/components/pwa-popup.css') }}">
    @stack('styles')
</head>


<body>
    @include('layouts.theme')
    @stack('start-scripts')
    
    <x-pwa-popup />

    @php
        // Code pour gérer le login utilisateur
        use App\Services\GestionPhotoDeProfil;
        if (Auth::check()) {
            $user = Auth::user();
            $user['chemin_photo_de_profil'] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
        }
    @endphp

    {{-- Barre de navigation --}}
    {{-- Si l'utilisateur est connecté : faire apparaître sa PFP au lieu du bouton Se Connecter --}}
    @if (Auth::check())
        <x-navbar :isConnected="true" :user="$user" />

        {{-- Sinon : mettre le bouton Se Connecter (la navbar normale) --}}
    @else
        <x-navbar :isConnected="false" :user="[]" />
    @endif

    @if (Auth::check() && (Auth::user()->promo == null || count(Auth::user()->campus) == 0))
        {{-- Si pas de promo ou pas de campus --}}
        <x-select-promo-campus-popup />
    @endif

    {{-- Contenu de la page --}}
    <div id="content">

        @yield('content')

        <footer>
            <a href="/a-propos">Fait avec amour par l'AIR - Tous droits réservés</a>
        </footer>
    </div>

    <script src="https://kit.fontawesome.com/1087e6f14a.js" crossorigin="anonymous"></script>
    @stack('end-scripts')


</body>

</html>
