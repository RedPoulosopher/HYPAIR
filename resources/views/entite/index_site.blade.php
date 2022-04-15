@extends('layouts.vide')

@section('titre', 'Entites')

@section('content')

<link rel="stylesheet" href="/css/entite.index.css" type="text/css" >

<div id="contenu" class="grand">
    @foreach($bureaux as $bureau)
        <h1>- Entites du {{ $bureau->nom }} -</h1>
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
            @foreach ($comites_clubs_dependants[$bureau->bureau_de_ratachement->value] as $comite_club)
                <a class="comite_club" href="{{$comite_club->lien_relatif()}}">
                    <div class="logo ombre_petite">
                        <div class="cercle" style="border-color: {{ $comite_club->couleur_sombre }}"></div>
                        <img src="{{ $comite_club->logo_url("petit") }}"/>
                    </div>
                    <div class="info" style="text-align:center;">
                        <p class="nom">{{ $comite_club->nom }}</p>
                        @if (!is_null($comite_club->categories))
                            <div class="categories">
                                @foreach (json_decode($comite_club->categories) as $categorie)
                                    <span>#{{$categorie}}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
