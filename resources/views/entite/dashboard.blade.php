@extends('layouts.app-without-sidebar')

@section('titre', 'Gestion de l\'entité')

@pushonce('styles')
    @vite('resources/css/entite/gestion.scss')
@endpushonce

@section('content')

    <main id="main-content">

        @php
        use \App\Services\AutorisationGestion;
        use \App\Enums\EntiteType;
        @endphp

        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>Gestion de l'entité</h1>
            <a class="logo" href="{{ $entite->lien_relatif() }}">
                <img src="{{ $logo_path }}" alt="logo" />
            </a>
            <div class="conteneur_boutons">

                <a class="modif_option card" href="dashboard/personnalisation">
                    <i class="fa-solid fa-palette"></i>Personnalisation
                </a>

                <a class="modif_option card" href="dashboard/reseau_social">
                    <i class="fa-solid fa-globe"></i>Réseaux sociaux
                </a>

                <a class="modif_option card" href="dashboard/post">
                    <i class="fa-solid fa-comment"></i>Posts
                </a>

                <a class="modif_option card" href="dashboard/event">
                    <i class="fa-regular fa-calendar"></i>Évènements
                </a>

                <a class="modif_option card" href="dashboard/entites">
                    <i class="fa-solid fa-crown"></i>Gérer les entités
                </a>

                <a class="modif_option card" href="dashboard/roles">
                    <i class="fa-solid fa-user-shield"></i>Rôles & permissions
                </a>

                <a class="modif_option card" href="dashboard/adherants">
                    <i class="fa-solid fa-users"></i>Adhérents
                </a>

                <a class="modif_option card" href="dashboard/groupes">
                    <i class="fa-solid fa-layer-group"></i>Groupes
                </a>

                <a class="modif_option card" href="dashboard/votes">
                    <i class="fa-solid fa-square-poll-vertical"></i>Votes
                </a>

                <a class="modif_option card" href="dashboard/fichiers">
                    <i class="fa-solid fa-folder"></i>Fichiers
                </a>

                <a class="modif_option card" href="dashboard/peertube">
                    <i class="fa-solid fa-video"></i>PeerTube
                </a>

                <a class="modif_option card" href="dashboard/photos">
                    <i class="fa-solid fa-image"></i>Photos
                </a>

                <a class="modif_option card" href="dashboard/boutique">
                    <i class="fa-solid fa-store"></i>Boutique
                </a>

                <a class="modif_option card" href="dashboard/paiements">
                    <i class="fa-solid fa-credit-card"></i>Paiements
                </a>

                <a class="modif_option card" href="dashboard/inventaire">
                    <i class="fa-solid fa-boxes-stacked"></i>Inventaire & prêts
                </a>

                <a class="modif_option card" href="dashboard/comptabilite">
                    <i class="fa-solid fa-calculator"></i>Comptabilité
                </a>

                <a class="modif_option card" href="dashboard/tournois">
                    <i class="fa-solid fa-trophy"></i>Gestion des tournois
                </a>

                <a class="modif_option card" href="dashboard/dm">
                    <i class="fa-solid fa-envelope"></i>Messages privés
                </a>

                <a class="modif_option card" href="dashboard/acces">
                    <i class="fa-solid fa-key"></i>Gestion des accès
                </a>
                
                <a class="modif_option card" href="dashboard/campagnes">
                    <i class="fa-solid fa-bullhorn"></i>Campagnes
                </a>
            </div>
            {{--<div class="conteneur_boutons">
                @if(AutorisationGestion::gestion_entite($entite))
                    <!--Les icônes viennent de https://fontawesome.com/-->
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
                    
                    @if ($entite['type'] == EntiteType::Bureau && AutorisationGestion::gestion('gerer_entite'))
                        <a class="modif_option card" href="../entites/gestion"><i class="fa-solid fa-crown"></i>Gérer les entités</a>
                    @endif
                    @if ($entite['uid'] == 'air' && AutorisationGestion::gestion('gerer_entite'))
                        <a class="modif_option card" href="../entites/admin"><i class="fa-solid fa-crown"></i>Gérer les entités</a>
                    @endif
                @else
                    <p class="no-content">Vous n'avez aucun droit sur cette entité</p>
                @endif
            </div>--}}
        </section>
    </main>


@endsection
