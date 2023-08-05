@extends('layouts.app')

@section('titre', 'Gestion de l\'entité')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/entite/gestion.css') }}" type="text/css" />
@endpushonce

@section('content')

    <main id="main-content">

        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>Gestion de l'entité</h1>
            <a class="logo" href="{{$entite->lien_relatif()}}">
                <img src="{{ session('entite_logo_petit') }}" alt="logo" />
            </a>
            <div class="conteneur_boutons">
                <a class="modif_option card" href="evenement"><i class="fa-regular fa-calendar"></i>Gérer les évènements</a>
                <a class="modif_option card" href="membres"><i class="fa-solid fa-users"></i>Gérer les membres</a>
                <a class="modif_option card" href="reseau_social"><i class="fa-solid fa-globe"></i>Gérer les réseaux sociaux</a>
                <a class="modif_option card" href="description"><i class="fa-solid fa-pen-to-square"></i>Modifier les descriptions et labels</a>
                <a class="modif_option card" href="logotype"><i class="fa-solid fa-eye"></i>Modifier le logo</a>
                <a class="modif_option card" href="couleur"><i class="fa-solid fa-palette"></i>Modifier les couleurs</a>
                @if ($entite['type'] == 'bureau' || $entite['uid'] == 'air')
                    <a class="modif_option card" href="../entites/admin"><i class="fa-solid fa-crown"></i>Gérer les entités</a>
                @endif
            </div>
        </section>
    </main>

    <script src="https://kit.fontawesome.com/1087e6f14a.js" crossorigin="anonymous"></script>

@endsection
