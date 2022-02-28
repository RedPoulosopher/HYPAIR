@extends('layouts.erreur')

@section('code_erreur', '403')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">403</h1>
    <h1>T'as pas le droit</h1>
    <p>C'est pas super cool d'essayer d'accèder à des trucs privés, tu sais ? Vois directement avec le bureau de l'association si tu penses que tu devrais y avoir accès.</p>
    
    <div class="centre-element bouton primaire" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
