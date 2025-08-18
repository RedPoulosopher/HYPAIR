@extends('layouts.app-without-sidebar')

@section('titre', 'Gestion de l\'entité')

@pushonce('styles')
    @vite('resources/css/entite/gestion.scss')
@endpushonce

@section('content')

    <main id="main-content">

        @php
        use \App\Services\AutorisationGestion;
        use \App\Enums\EntiteTypeEnum;
        @endphp

        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>Gestion de l'entité</h1>
            <a class="logo" href="{{ $entite->lien_relatif() }}">
                <img src="{{ session('entite_logo_petit') }}" alt="logo" />
            </a>
            <div class="conteneur_boutons">
                @if(AutorisationGestion::gestion_entite($entite))
                    {{-- Les icônes viennent de https://fontawesome.com/ --}}
                    @if(AutorisationGestion::gestion('gerer_post'))
                        <a class="modif_option card" href="post"><i class="fa-solid fa-comment"></i>Gérer les posts</a>
                    @endif
                    @if(AutorisationGestion::gestion('gerer_evenement'))
                        <a class="modif_option card" href="evenement"><i class="fa-regular fa-calendar"></i>Gérer les évènements</a>
                    @endif
                    @if(AutorisationGestion::gestion('gerer_membre'))
                        <a class="modif_option card" href="membres"><i class="fa-solid fa-users"></i>Gérer les membres</a>
                    @endif
                    @if(AutorisationGestion::gestion('gerer_reseau'))
                        <a class="modif_option card" href="reseau_social"><i class="fa-solid fa-globe"></i>Gérer les réseaux sociaux</a>
                    @endif
                    @if(AutorisationGestion::gestion('gerer_entite'))
                        <a class="modif_option card" href="informations"><i class="fa-solid fa-circle-info"></i>Modifier les informations</a>
                        <a class="modif_option card" href="description"><i class="fa-solid fa-pen-to-square"></i>Modifier les descriptions et labels</a>
                        <a class="modif_option card" href="logotype"><i class="fa-solid fa-eye"></i>Modifier le logo</a>
                        <a class="modif_option card" href="couleur"><i class="fa-solid fa-palette"></i>Modifier les couleurs</a>
                    @endif
                    
                    @if ($entite['type'] == EntiteTypeEnum::Bureau && AutorisationGestion::gestion('gerer_entite'))
                        <a class="modif_option card" href="../entites/gestion"><i class="fa-solid fa-crown"></i>Gérer les entités</a>
                    @endif
                    @if ($entite['uid'] == 'air' && AutorisationGestion::gestion('gerer_entite'))
                        <a class="modif_option card" href="../entites/admin"><i class="fa-solid fa-crown"></i>Gérer les entités</a>
                    @endif
                @else
                    <p class="no-content">Vous n'avez aucun droit sur cette entité</p>
                @endif
            </div>
        </section>
    </main>


@endsection
