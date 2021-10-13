@extends('layouts.erreur')

@section('code_erreur', '405')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">405</h1>
    <h1>Mince, cette association n'existe pas</h1>
    <p>Si tu veux créer ton association, tu peux le faire en demandant au BDX que tu penses concerné. S'il s'agit juste d'une erreur, tu peux <a style="color:var(--couleur_accentuation); text-decoration:underline;cursor:pointer;" onclick="history.back()">revenir d'où tu viens</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <a href="/contact"><div class="bouton primaire icon-after-document ombre_petite"><span>Nous contacter</span></div></a>
    </div>
@endsection
