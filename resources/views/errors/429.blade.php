@extends('layouts.erreur')

@section('code_erreur', '419')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">419</h1>
    <h1>Wow, calme toi s'il te plaît !</h1>
    <p>On ne sait pas ce que tu essayes de faire, mais ça nous semble super bizarre... Si j'arrive à compter sur mes mains, tu as fait au moins... Fiou... Ohlala... Je vais essayer de compter avec mes pieds... Ah non, toujours pas assez. Bref, respire un grand coup et recommance.</p>
    
    <div class="centre-element bouton primaire" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
