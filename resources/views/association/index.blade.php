@extends('layouts.app')

@section('titre', 'Associations')

@section('content')
@php
use \App\Services\GestionLogo;
@endphp

<style>
div.table {
    border: 1px solid var(--gris_1);
    border-top-color: var(--couleur_accentuation);
    box-sizing: border-box;
    border-radius: 15px;
    margin-top:40px;
    overflow: hidden;
    background-color: var(--gris_2);
}
#liste_assos {
    display: flex;
    gap: 40px;
    justify-content: center;
    flex-wrap: wrap;
}
.asso {
    width:200px;
}
.asso .logo {
    position: relative;
    width:100%;
    border-radius: 500px;
    background: var(--gris_2);
}
.asso .logo img {
    width:84%;
    margin: 8%;
    border-radius: 500px;
}
.asso .logo .cercle {
    border-radius: 500px;
    border:2px solid;
    position:absolute;
    left:5%;
    top:5%;
    width:90%;
    height:90%;
    box-sizing: border-box;
    transition: border 0.1s ease-in-out;
}
.asso .logo:hover .cercle {
    border: 5px solid;
}
</style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- Associations du {{ $bureau->nom }} -</h1>

        <div id="liste_assos">
            @foreach ($assos_dependantes as $asso)
                <a class="asso" href="https://{{ $asso->uid }}.imt-ne.fr">
                    <div class="logo ombre_petite">
                        <div class="cercle" style="border-color: {{ $asso->couleur_sombre }}"></div>
                        <img src="{{ GestionLogo::recuperer_dernier_logo("moyen",$asso->id) }}"/>
                    </div>
                    <div class="info" style="text-align:center;">
                        <span>{{ $asso->nom }}</span>
                    </div>
                </a>
            @endforeach
        </div>
	</div>
</div>
@endsection
