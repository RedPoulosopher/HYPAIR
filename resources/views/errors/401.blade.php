@extends('layouts.erreur')

@section('code_erreur', '401')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">401</h1>
    <h1>Il nous manque quelque chose</h1>
    <p>On n'est pas totalement sûr que tu ais bien le droit de venir ici. Tu peux toujours <a href="/contact" style="color:var(--couleur_accentuation_air); text-decoration:underline;" >nous contacter</a> si tu penses que c'est une erreur.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
