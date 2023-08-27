{{-- Page d'edition du profil utilisateur, peut y changer photo de profil, nom, prenom, pronoms, promo.
On voit le mail et le pseudo user associé sans pouvoir le changer. --}}

@extends('layouts.app-without-sidebar')

@section('titre', 'Editer la photo de profil')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/espace_utilisateur/editer_photo_profil.css') }}" type="text/css">
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
                    <label class="input_groupe">
                        <div id="photo_profil">
                            <img id="photo_profil_img" src="{{ $user->chemin_photo_de_profil }}"
                                alt="Preview votre photo de profil" />
                        </div>
                        <p id="bouton_modifier" class="bouton primaire" tabindex="1"
                            style="margin-left: auto; margin-right: auto;">Modifier</p>
                        <input name="input-photo" type="file" accept="image/*" required style="display: none;"
                            onchange="affichage_photo_dynamique(event)" />
                    </label>
                </div>
                <button id="bouton_submit" type="submit" tabindex="1" class="bouton primaire cacher" style="float:right;"
                    onclick="validation()">VALIDER</button>
            </form>
        </section>
    </main>
@endsection

<script>
    /*affichage dynamique*/
    var bouton_submit;
    var photo_profil;
    /*accessibilité*/
    var bouton_modifier;

    window.onload = init;

    function init() {
        /*affichage dynamique*/
        bouton_submit = document.getElementById('bouton_submit');
        photo_profil = document.getElementById('photo_profil_img');
        bouton_modifier = document.getElementById('bouton_modifier');
        /*accessibilité*/
        bouton_modifier.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                bouton_modifier.click();
            }
        });
    };

    /*affichage dynamique*/
    function affichage_photo_dynamique(event) {
        if (event.target.files[0].size > 1024000000) {
            alert(
                "Cette image est sûrement très qualitative, mais on aimerait éviter qu'elle fasse brûler nos serveur. Réessaye avec une image plus legère ;)"
                );
            event.target.value = "";
        } else {
            bouton_submit.className = "bouton primaire afficher";
            photo_profil.src = URL.createObjectURL(event.target.files[0]);
            photo_profil.onload = function() {
                URL.revokeObjectURL(photo_profil.src) // free memory
            }
        }
    };

    function validation() {
        bouton_submit.innerText = "VALIDATION ...";
    };
</script>
