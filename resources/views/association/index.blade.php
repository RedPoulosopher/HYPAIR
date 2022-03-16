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
#liste_comite {
    display: flex;
    gap: 20px 20px;
    justify-content: center;
    flex-wrap: wrap;
}
.comite {
    width:240px;
}
.comite .logo {
    position: relative;
    width:200px;
    height:200px;
    margin-left:auto;
    margin-right:auto;
    border-radius: 500px;
    background: var(--gris_2);
}
.comite .logo img {
    width:84%;
    margin: 8%;
    border-radius: 500px;
}
.comite .logo .cercle {
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
.comite .logo:hover .cercle {
    border: 5px solid;
}

.comite .info .nom {
    font-size:2em;
    line-height: 0.8em;
    margin-block-start: 0.3em;
    margin-block-end: 0.3em;
    text-transform: capitalize;
}
.comite .info .categories {

}
.comite .info .categories {
	font-size: 0.85em;
	color:var(--couleur_police_secondaire);
    display:flex;
    flex-wrap: wrap;
    justify-content: center;
    gap:5px;
}
.categories > span {
	background: var(--gris_1);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}
</style>

<div id="wrapper">
	<div id="contenu" class="grand">
		<h1>- Associations du {{ $bureau->nom }} -</h1>

        <div id="liste_comite">
            @foreach ($comites_dependants as $comite)
                <a class="comite" href="{{$comite->url()}}">
                    <div class="logo ombre_petite">
                        <div class="cercle" style="border-color: {{ $comite->couleur_sombre }}"></div>
                        <img src="{{ $comite->logo_url("petit") }}"/>
                    </div>
                    <div class="info" style="text-align:center;">
                        <p class="nom">{{ $comite->nom }}</p>
                        @if (!is_null($comite->categories))
                            <div class="categories">
                                @foreach (json_decode($comite->categories) as $categorie)
                                    <span>#{{$categorie}}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
	</div>
</div>
@endsection
