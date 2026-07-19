@extends('layouts.app')
@section('titre', 'Associations')
@pushonce('styles')
    @vite([
        'resources/css/entite/entite.scss',
        'resources/css/components/entite.scss',
    ])
@endpushonce
@section('content')
    <main id="main-content">
        <x-switch-campus :campus="$site" />
        <section>
            @if (count($bureaux) > 0)
                @foreach ($bureaux as $bureau)
                    @if (!$bureau->hidden)
                        <h1>Entités du {{ $bureau->name }}</h1>
                        {{-- Bureau --}}
                        @if($bureau->sites->contains('id', $site->id))
                            <div class="liste_comite_club">
                                <x-entite :asso="$bureau" :destination="$bureau->lien_relatif()" />
                            </div>        
                        @endif
                    
                        {{-- Comités du bureau--}}
                        @if(count($clubs_comites[$bureau->uid]) > 0)
                            <div class="liste_comite_club">
                                @foreach ($clubs_comites[$bureau->uid] as $club_comite)
                                    <x-entite :asso="$club_comite" :destination="$club_comite->lien_relatif()" />
                                @endforeach
                            </div>
                        @endif
                    @endif
                @endforeach

                @if (count($entites_independantes ?? []) > 0)
                    <h1>Entites indépendantes</h1>
                    <div class="liste_comite_club">
                        @foreach ($entites_independantes as $entite_independante)
                            <x-entite :asso="$entite_independante" :destination="$entite_independante->lien_relatif()" />
                        @endforeach
                    </div>
                @endif
            @else
                <p class="should-be-connected no-content">Pas d'associations pour le moment.</p>
            @endif
        </section>
    </main>

    <script>
        site = window.location.pathname.split('/').pop()
        localStorage.setItem('defaut_entites_index_site', site)
    </script>
@endsection
