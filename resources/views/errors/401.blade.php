@extends('layouts.erreur')

@section('code_erreur', '401')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">401</h1>
    <h1>Il nous manque quelque chose</h1>
    <p>On n'est pas totalement sûr que tu ais bien le droit de venir ici. Tu peux toujours <a href="https://air.imt-ne.fr/contact" class="couleur">nous contacter</a> si tu penses que c'est une erreur.</p>

    <div class="centre-element bouton primaire ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
