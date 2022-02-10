@extends('layouts.erreur')

@section('code_erreur', '405')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">405</h1>
    <h1>Mince, cette association n'existe pas</h1>
    <p>Si tu veux créer ton association, tu peux le faire en demandant au BDx concerné. S'il s'agit d'une erreur, tu peux <a href="https://air.imt-ne.fr/contact" class="couleur">nous contacter</a>.</p>
    
    <div class="centre-element bouton primaire ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
