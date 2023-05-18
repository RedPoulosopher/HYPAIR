@extends('layouts.leger')

@section('titre', 'Entités')

@section('content')

<link rel="stylesheet" href="/css/entite.index.css" type="text/css" >

<style>
    #wrapper {
    flex-direction: column;
    overflow-x: hidden;
    min-height: 110%;
    }
</style>


<div id="wrapper">
    <div id="contenu" class="grand">
        <a href="/" class="bouton retour">< retour au choix du site</a>
        @foreach($bureaux as $bureau)
            <h1>- Entités du {{ $bureau->nom }} -</h1>
            <div class="liste_comite_club">
                <a class="comite_club" href="{{$bureau->lien_relatif()}}">
                    <div class="logo ombre_petite">
                        <div class="cercle" style="border-color: {{ $bureau->couleur_sombre }}"></div>
                        <img src="{{ $bureau->logo_url("petit") }}"/>
                    </div>
                    <div class="info" style="text-align:center;">
                        <p class="nom">{{ $bureau->nom }}</p>
                    </div>
                </a>
            </div>
    
            <div class="liste_comite_club">
                @foreach ($comites_clubs_dependants[$bureau->ratachement->value] as $comite_club)
                    <a class="comite_club" href="{{$comite_club->lien_relatif()}}">
                        <div class="logo ombre_petite">
                            <div class="cercle" style="border-color: {{ $comite_club->couleur_sombre }}"></div>
                            <img src="{{ $comite_club->logo_url("petit") }}"/>
                        </div>
                        <div class="info" style="text-align:center;">
                            <p class="nom">{{ $comite_club->nom }}</p>
                            {{-- <div class="categories">
                                @foreach ($comite_club->categories() as $categorie)
                                    <span>#{{$categorie->label}}</span>
                                @endforeach
                            </div> --}}
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    
        @if (count($entites_independantes ?? array()) > 0)
            <h1>- Entites indépendantes -</h1>
            <div class="liste_comite_club">
                @foreach ($entites_independantes as $entite_independante)
                    <a class="comite_club" href="{{$entite_independante->lien_relatif()}}">
                        <div class="logo ombre_petite">
                            <div class="cercle" style="border-color: {{ $entite_independante->couleur_sombre }}"></div>
                            <img src="{{ $entite_independante->logo_url("petit") }}"/>
                        </div>
                        <div class="info" style="text-align:center;">
                            <p class="nom">{{ $entite_independante->nom }}</p>
                            <div class="categories">
                                {{-- @foreach ($comite_club->categories() as $categorie)
                                    <span>#{{$categorie->label}}</span>
                                @endforeach --}}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
site = window.location.pathname.split('/').pop()
localStorage.setItem('defaut_entites_index_site', site)
</script>
@endsection
