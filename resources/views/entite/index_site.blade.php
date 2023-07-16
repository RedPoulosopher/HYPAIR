@extends('layouts.app')
@section('titre', 'Associations')
@pushonce('styles')
    <link rel="stylesheet" href="/css/entite.index.css" type="text/css">
@endpushonce
@section('content')
    <main id="main-content">
        <div id="contenu" class="grand">
            <a href="/" class="bouton retour">
                < retour au choix du site</a>
                    @foreach ($bureaux as $bureau)
                        <h1>Entités du {{ $bureau->nom }}</h1>
                        <div class="liste_comite_club">
                            <x-entite :asso="$bureau" />
                        </div>

                        <div class="liste_comite_club">
                            @foreach ($comites_clubs_dependants[$bureau->ratachement->value] as $comite_club)
                                <x-entite :asso="$comite_club" />
                            @endforeach
                        </div>
                    @endforeach

                    @if (count($entites_independantes ?? []) > 0)
                        <h1>Entites indépendantes</h1>
                        <div class="liste_comite_club">
                            @foreach ($entites_independantes as $entite_independante)
                                <x-entite :asso="$entite_independante" />
                            @endforeach
                        </div>
                    @endif
        </div>
    </main>

    <script>
        site = window.location.pathname.split('/').pop()
        localStorage.setItem('defaut_entites_index_site', site)
    </script>
@endsection
