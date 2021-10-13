@extends('layouts.erreur')

@section('code_erreur', '403')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">403</h1>
    <h1>T'as pas le droit</h1>
    <p>C'est pas super cool d'essayer d'accèder à des trucs privés, tu sais ? Néanmoins, comme nous sommes des singes, il est toujours possible que ce soit une erreur de notre part. Si tu penses que tu as le droit d'avoir accès à cette ressource, contact nous. Sinon, tu peux <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <a href="/contact"><div class="bouton primaire icon-after-document ombre_petite"><span>Nous contacter</span></div></a>
    </div>
@endsection
