@extends('layouts.app')
@section('titre', 'Associations')
@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/entite/entite.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/components/entite.css') }}" type="text/css">
@endpushonce
@section('content')
    <main id="main-content">
        <x-switch-campus :campus="$site" />
        <section>
            @foreach ($bureaux as $bureau)
                @if (!$bureau->hidden)
                    <h1>Entités du {{ $bureau->nom }}</h1>
                    <div class="liste_comite_club">
                        <x-entite :asso="$bureau" :destination="$bureau->lien_relatif()" />
                    </div>

                    <div class="liste_comite_club">
                        @foreach ($comites_clubs_dependants[$bureau->ratachement->value] as $comite_club)
                            @if (!$comite_club->hidden)
                                <x-entite :asso="$comite_club" :destination="$comite_club->lien_relatif()" />
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach

            @if (count($entites_independantes ?? []) > 0)
                <h1>Entites indépendantes</h1>
                <div class="liste_comite_club">
                    @foreach ($entites_independantes as $entite_independante)
                        @if (!$entite_independante->hidden)
                            <x-entite :asso="$entite_independante" :destination="$entite_independante->lien_relatif()" />
                        @endif
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
