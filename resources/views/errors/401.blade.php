@extends('layouts.erreur')

@section('code_erreur', '401')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">401</h1>
    <h1>Il nous manque quelque chose</h1>
    <p>On n'est pas totalement sûr que tu ais bien le droit de venir ici. Tu peux toujours <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <a href="/contact"><div class="bouton primaire icon-after-document ombre_petite"><span>Nous contacter</span></div></a>
    </div>
@endsection
