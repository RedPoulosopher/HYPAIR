@extends('layouts.erreur')

@section('code_erreur', '405')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">405</h1>
    <h1>Mince, cette association n'existe pas</h1>
    <p>Si tu veux créer ton association, tu peux le faire en demandant au BDX que tu penses concerné. S'il s'agit d'une erreur, tu peux  <a href="/contact" style="color:var(--couleur_accentuation_air); text-decoration:underline;cursor:pointer;" >nous contacter</a>.</p>
    <div class="centre-element" style="margin-top:50px;">
        <div class="bouton primaire icon-after-document ombre_petite" onclick="history.back()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Revenir d'où tu viens</span></div>
    </div>
@endsection
