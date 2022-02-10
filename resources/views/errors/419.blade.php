@extends('layouts.erreur')

@section('code_erreur', '419')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">419</h1>
    <h1>Ta session a expiré</h1>
    <p>On sait pas vraiment ce que ça veut dire, déso. Tu peux essayer de rafraîchir la page, sur un malentendu ça marche..</p>
    
    <div class="centre-element bouton primaire ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer; margin-top:50px;"><span>Revenir d'où tu viens</span></div>
@endsection
