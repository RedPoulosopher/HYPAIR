@extends('layouts.erreur')

@section('code_erreur', '503')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">503</h1>
    <h1>Nous travaillons ici ! Tu pourras bientôt revenir</h1>
    <p>Nos meilleurs ingénieurs travaillent sur une amélioration du site. Si tu veux vraiment nous parler, tu peux toujours nous contacter !</p>
    <div class="centre-element" style="margin-top:50px;">
        <a href="mailto:air@etu.imt-nord-europe.fr"><div class="bouton primaire icon-after-document ombre_petite"><span>Nous contacter</span></div></a>
    </div>
@endsection
