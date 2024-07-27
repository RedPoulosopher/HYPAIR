@extends('layouts.app')

@section('titre', 'Entités')

@pushonce('styles')
    @vite([
        'resources/css/entite/entite.scss',
        'resources/css/components/entite.scss',
    ])
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1>Entités du {{ $bureau->nom }}</h1>

        <div class="liste_comite_club">
            @foreach ($comites_clubs_dependants as $comite_club)
                <a class="comite_club" href="{{$comite_club->url()}}">
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
	</section>
</main>
@endsection
