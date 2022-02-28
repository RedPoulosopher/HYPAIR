@extends('layouts.erreur')

@section('code_erreur', '401')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">401</h1>
    <h1>Pourquoi t'es pas connecté ?</h1>
    <p>Si tu veux venir ici, tu dois être connecté. On prend la sécurité très au serieux, on déconne pas. Alors va au plus vite <a href="/connexion" class="couleur">te connecter</a>.</p>

    <div class="centre-element bouton primaire" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
