@extends('layouts.erreur')

@section('code_erreur', '419')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">419</h1>
    <h1>Wow, calme toi s'il te plaît !</h1>
    <p>On ne sait pas ce que tu essayes de faire, mais ça nous semble super bizarre... Si j'arrive à compter sur mes mains, tu as fait au moins... Fiou... Ohlala... Je vais essayer de compter avec mes pieds... A non, toujours pas assez. Bref, respire un grand coup et recommance. Tu peux essayer de <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
