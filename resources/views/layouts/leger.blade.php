<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titre', 'Test') - HypAIR</title>
    <link rel="stylesheet" href="/css/app.css?v=101" type="text/css">
</head>

<body class="dark-theme">
@php
    use App\Services\GestionPhotoDeProfil;
    if (Auth::check()) {
        $user = Auth::user();
        $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
    }
@endphp

@if (Auth::check())
    <div id="lien_profil"><a href="/home"><img id="photo_lien_profil" src="{{$user->chemin_photo_de_profil}}"
                                               title="{{$user->prenom}} {{$user->nom}}"/></a></div>
@else
    <a href="/home" id="bouton_se_connecter" class="bouton primaire">Se connecter</a>
@endif
@include('layouts.theme')

@include('partials.theme-bascule')

@include('fenetre_contextuelle.#defaut')

@yield('content')
</body>
</html>
