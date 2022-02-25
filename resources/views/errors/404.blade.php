@extends('layouts.erreur')

@section('code_erreur', '404')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">404</h1>
    <h1>On a rien trouvé</h1>
    <p>Les meilleurs ingénieurs de la MDE se sont penchés sur le sujet, mais rien ne correspond à ce que tu as demandé. Déso pas déso</p>
    
    <div class="centre-element bouton primaire ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
