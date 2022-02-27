@extends('layouts.erreur')

@section('code_erreur', '500')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">500</h1>
    <h1>Oups, c'est pas normal</h1>
    <p>Désolé, on ne sait vraiment pas ce qu'il s'est passé. <a href="https://air.imt-ne.fr/contact" class="couleur" >contacte nous</a> en précisant ce que tu as fait pour arriver là..</p>
    
    <div class="centre-element bouton primaire ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
