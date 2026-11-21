{{-- Page d'edition du profil utilisateur, peut y changer photo de profil, nom, prenom, pronoms, promo.
On voit le mail et le pseudo user associé sans pouvoir le changer. --}}

@extends('layouts.app')

@section('titre', 'Editer la photo de profil')

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
        'resources/css/espace_utilisateur/editer_photo_profil.scss',
    ])
@endpushonce

@section('content')
    <main id="main-content">
        <section>
            <h1><span class="icon-profile-circle"></span> Modifier la photo de profil</h1>
            {{-- ancien bouton retour ci-dessous, a enlever lorsde l'ajout des breadcrumbs --}}
            {{-- <a href="/home" class="bouton secondaire">< Retour au profil</a> --}}

            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="groupe card">
                    @if ($errors->any())
                        <div class="erreurs" style="max-width: 260px;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif


                    <x-image_file :nameGrpFile="'Photo de profile'" :alea="'photo'" :urlImg="$user->chemin_photo_de_profil ?? ''" :displayMode="0"/>
                </div>
                <button id="bouton_submit" type="submit" tabindex="1" class="bouton primaire" style="float:right;">VALIDER</button>
            </form>
        </section>
    </main>
@endsection
