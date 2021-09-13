@extends('layouts.erreur')

@section('code_erreur', '419')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">419</h1>
    <h1>Ta session a expiré</h1>
    <p>On sait pas vraiment ce que ça veut dire, déso. Tu peux essayer de rafraîchir la page, sur un malentendu ça marche. Sinon, tu peux <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
