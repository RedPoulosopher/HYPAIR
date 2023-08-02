@extends('layouts.app-without-sidebar')

@section('titre', $entite->nom)

@pushonce('styles')
@endpushonce
<link rel="stylesheet" href="{{ mix('css/entite/a_propos.css') }}">
@section('content')

    <main id="main-content">
        <section>

            <h1>à propos de {{ $entite->nom }}</h1>
            <div class="logo">
                <img src="{{ session('entite_logo_petit') }}" alt="logo" />
            </div>
            @if (!is_null($entite->categories))
                <div class="categories">
                    @foreach ($categories as $categorie)
                        <span>#{{ $categorie->label }}</span>
                    @endforeach
                </div>
            @endif
            <div class="description">
                {!! Str::markdown($entite->description_md ?? ($entite->description_courte ?? '')) !!}
            </div>
            <div class="reseaux_sociaux grille-enfants">
                @foreach ($reseaux_sociaux as $reseau_social)
                    <x-reseau-social :reseau="$reseau_social" />
                @endforeach
            </div>

            <h1 class="espace">mandat</h1>
            <div class="membres grille-enfants">
                @foreach ($mandat as $mandat_user)
                    <div>
                        <div class="photo centre-element" title="Voir le profil" tabindex="0"
                            onclick="afficher_info_membre({{ $mandat_user->id }})">
                            <div class="cercle"></div>
                            <img class="ombre_petite" src="{{ $mandat_user->lien_photo }}"
                                alt="Photo de profil de {{ $mandat_user->prenom . ' ' . $mandat_user->nom }}" />
                        </div>
                        <div class="info" style="text-align:center;">
                            <span>{{ $mandat_user->prenom . ' ' . $mandat_user->nom }}</span>
                            <br>
                            <span>{{ $mandat_user->label }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
            </div>

            <div id="modal_info_membre">
                <span id="close_modal" class='icon-close-square' tabindex="0" onclick="fermer_info_membre()"></span>
                <div id="profil">
                    @foreach ($mandat as $mandat_user)
                        <div id="profil_{{ $mandat_user->id }}" class="profil">
                            <div class="photo_profil">
                                <img src="{{ $mandat_user->lien_photo_utilisateur }}" alt="Votre photo de profil" />
                            </div>
                            <div class="info_profil">
                                <div class="prenoms">
                                    <h2>{{ $mandat_user->user_info->prenom . ' ' . $mandat_user->user_info->nom }}</h2>
                                    @if ($mandat_user->user_info->pronom !== '')
                                        <h2 class="pronoms">•</h2>
                                        <h2 class="pronoms">{{ $mandat_user->user_info->pronom }}</h2>
                                    @endif
                                </div>
                                <div class="bio">
                                    {!! nl2br(e($mandat_user->user_info->bio)) !!}
                                </div>
                                <div class="reseaux_sociaux_profil grille-enfants">
                                    @foreach ($mandat_user->reseaux_sociaux as $reseau_social_user)
                                        <x-reseau-social :reseau="$reseau_social_user" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection

<script>
    var modal_info_membre;
    var current = null;

    window.onload = init;

    function init() {
        modal_info_membre = document.getElementById("modal_info_membre");
    };


    function afficher_info_membre(user_id) {
        modal_info_membre.style.display = "grid";
        if (current != user_id) {
            if (current != null) {
                document.getElementById("profil_" + current).style.display = "none";
            };
            current = user_id;
            document.getElementById("profil_" + user_id).style.display = "flex";
        };
    };

    function fermer_info_membre() {
        modal_info_membre.style.display = "none";
    };
</script>
