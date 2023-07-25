@extends('layouts.app')
@section('titre', 'Associations')
@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('css/entite.css') }}" type="text/css">
@endpushonce
@section('content')
    <main id="main-content">
        <x-switch-campus :campus="$site" />
        <section>
            @foreach ($bureaux as $bureau)
                <h1>Entités du {{ $bureau->nom }}</h1>
                <div class="liste_comite_club">
                    <x-entite :asso="$bureau" :destination="$bureau->lien_relatif()" />
                </div>

                <div class="liste_comite_club">
                    @foreach ($comites_clubs_dependants[$bureau->ratachement->value] as $comite_club)
                        <x-entite :asso="$comite_club" :destination="$comite_club->lien_relatif()" />
                    @endforeach
                </div>
            @endforeach

            @if (count($entites_independantes ?? []) > 0)
                <h1>Entites indépendantes</h1>
                <div class="liste_comite_club">
                    @foreach ($entites_independantes as $entite_independante)
                        <x-entite :asso="$entite_independante" :destination="$entite_independante->lien_relatif()" />
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <script>
        site = window.location.pathname.split('/').pop()
        localStorage.setItem('defaut_entites_index_site', site)
    </script>
@endsection
