@extends('layouts.erreur')

@section('code_erreur', '500')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">500</h1>
    <h1>Oups, c'est pas normal</h1>
    <p>Désolé, on ne sait vraiment pas ce qu'il s'est passé. Contacte nous en précisant ce que tu as fait pour arriver là. En attendant, tu peux essayer de <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <a href="mailto:air@etu.imt-nord-europe.fr"><div class="bouton primaire icon-after-document ombre_petite"><span>Nous contacter</span></div></a>
    </div>
@endsection
