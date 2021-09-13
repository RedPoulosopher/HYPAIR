@extends('layouts.erreur')

@section('code_erreur', '404')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">404</h1>
    <h1>On a rien trouvé</h1>
    <p>Les meilleurs ingénieurs de la MDE se sont penchés sur le sujet, mais rien ne correspond à ce que tu as demandé.</p>
    <p>Si tu penses que les (super) membres de l'AIR ont mal fait leur travail, n'hésite pas à venir le leur dire, en leur expliquant pourquoi tu penses que la page que tu essayes de visiter devrait exister. Sinon, tu peux <a href="/contact" style="color:var(--couleur_accentuation_air); text-decoration:underline;" >nous contacter</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
