@extends('layouts.erreur')

@section('code_erreur', '403')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">403</h1>
    <h1>T'as pas le droit</h1>
    <p>C'est pas super cool d'essayer d'accèder à des trucs privés, tu sais ? Néanmoins, comme nous sommes des singes, il est toujours possible que ce soit une erreur de notre part. Si tu penses que tu as le droit d'avoir accès à cette ressource, <a href="/contact" style="color:var(--couleur_accentuation_air); text-decoration:underline;" >contacte nous</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
