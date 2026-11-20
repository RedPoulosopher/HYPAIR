@extends('layouts.app-without-sidebar')

@section('titre', 'Gestion de l\'entité')

@pushonce('styles')
    @vite('resources/css/entite/gestion.scss')
@endpushonce

@section('content')

    <main id="main-content">

        <section>
            <div class="conteneur_boutons">

                <a class="modif_option card" href="">
                    <i class="fa-solid fa-crown"></i>Gérer les entités
                </a>

                <a class="modif_option card" href="">
                    <i class="fa-solid fa-user-shield"></i>Rôles & permissions
                </a>

                <a class="modif_option card" href="dashboard/groupes">
                    <i class="fa-solid fa-layer-group"></i>Groupes
                </a>

                <a class="modif_option card" href="dashboard/fichiers">
                    <i class="fa-solid fa-folder"></i>Fichiers
                </a>

                <a class="modif_option card" href="dashboard/photos">
                    <i class="fa-solid fa-image"></i>Photos
                </a>

                <a class="modif_option card" href="{{ route('controller-acces.index') }}">
                    <i class="fa-solid fa-key"></i>Gestion des accès
                </a>
            </div>
        </section>
    </main>


@endsection
