{{-- créer un model de carte avec un form (entity_name,subtitle,color...,image_logo,image_background, check poste --}}
@extends('layouts.app-without-sidebar')
@section('titre', 'Créer une carte')
@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
        'resources/css/documentation.scss',
		'resources/css/simpleMDE.scss',
    ])
@endpushonce

@section('content')
<?php
    function couleur_opposee($couleur){
        $couleur = ltrim($couleur, '#');
        $couleur = substr($couleur, 0, 6);
        $r = dechex(255 - hexdec(substr($couleur,0,2)));
        $r = (strlen($r) > 1) ? $r : '0'.$r;
        $g = dechex(255 - hexdec(substr($couleur,2,2)));
        $g = (strlen($g) > 1) ? $g : '0'.$g;
        $b = dechex(255 - hexdec(substr($couleur,4,2)));
        $b = (strlen($b) > 1) ? $b : '0'.$b;
        return "#".$r.$g.$b."ff";
    }
?>
<main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer une carte</h1>
            
            <div class="section-content">
                @if (Session::has('success'))
                    <p class="explication">L'entite a été créée correctement ! Elle est disponible.</p>
                @endif
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="erreurs">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="groupe card">

                        @include("components.card_view",["card"=>null])
                        
                        <label class="input_groupe">
                            <p class="titre">* Nom de la carte :</p>
                            <input class="input" type="text" id="nom" name="title" value="{{ $entite->name }}" required autocomplete="off">
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Sous-titre :</p>
                            <input class="input" type="text" id="subtitle" name="subtitle" value="Carte adhérant" required autocomplete="off">
                        </label>
                        
                        <label class="input_groupe">
                            <p class="titre">* Couleur 1 :</p>
                            <input type="color" class="input" name="couleur1" class="input" required id="couleur1" value="{{old('couleur1') ?? $entite->color_1 ?? '#ffffffff'}}">
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Couleur 2 :</p>
                            <input type="color" class="input" name="couleur2" class="input" required id="couleur2" value="{{old('couleur2') ?? $entite->color_2 ?? '#000000ff'}}">
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Couleur du texte 1 :</p>
                            <input type="color" class="input" id="couleur_text1" name="couleur_text1" required value="{{old('couleur_text1') ?? couleur_opposee($entite->color_1) ?? '#000000ff'}}">
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Couleur du texte 2 :</p>
                            <input type="color" class="input" id="couleur_text2" name="couleur_text2" required value="{{old('couleur_text2') ?? couleur_opposee($entite->color_2) ?? '#000000ff'}}">
                        </label>
                        
                        <label class="input_groupe">
							<p class="titre">Logo :</p>
							<p class="description">Soit un svg de moins de 70ko, soit une image de plus de 512px par côté.</p>


                            <div id="photo_profil">
                                <img id="photo_profil_img" src="{{ $entite->getLogo?->url() }}"
                                    alt="Preview votre photo de profil" />
                            </div>
                            <label id="file-upload">
								<input type="file" name="logo" class="input" id="original_input" accept="image/*" onchange="affichage_photo_dynamique(event)">
								Sélectionnez un fichier
							</label>
							<span id="filename">Aucun fichier sélectionné</span>
                        </label>
                    
                        <label for="image_background">Image de fond (optionnel) :</label>
                        <input type="file" id="image_background" name="image_background" accept="image/*">
                    </div>
                    
                    <span>* Les champs marqués d'une astérisque sont obligatoires</span>
                    <button type="submit" class="bouton primaire ombre_petite"
                        style="float:right;"><span>{{ 1 ? 'CRÉER' : 'MODIFIER' }}</span></button>
                </form>
            </div>
        </section>
    </main>

<script>
    document.getElementById('image-logo info-card').src = "{{ $entite->getLogo?->url() }}";
    document.getElementById('user_name info-card').textContent = 'Nom Prénom'
    document.getElementById('title info-card').textContent = document.getElementById('nom').value;
    document.getElementById('nom').addEventListener('input', function() {
        document.getElementById('title info-card').textContent = this.value;
    });
    document.getElementById('subtitle info-card').textContent = document.getElementById('subtitle').value;
    document.getElementById('subtitle').addEventListener('input', function() {
        document.getElementById('subtitle info-card').textContent = this.value;
    });
    document.querySelector('.bg-svg rect').setAttribute('fill', document.getElementById('couleur1').value);
    document.getElementById('couleur1').addEventListener('input', function() {
        document.querySelector('.bg-svg rect').setAttribute('fill', this.value);

        document.getElementById('svg info-card').style='';
        document.getElementById('svg info-card').parentElement.style="";
    });
    document.querySelector('.bg-svg path').setAttribute('fill', document.getElementById('couleur2').value);
    document.getElementById('couleur2').addEventListener('input', function() {
        document.querySelector('.bg-svg path').setAttribute('fill', this.value);

        document.getElementById('svg info-card').style='';
        document.getElementById('svg info-card').parentElement.style="";
    });
    Array.from(document.getElementById("brand-text info-card").children).forEach(el => {
        el.style.color = document.getElementById('couleur_text1').value;
    });
    document.getElementById('couleur_text1').addEventListener('input', function() {
        Array.from(document.getElementById("brand-text info-card").children).forEach(el => {
            el.style.color = this.value;
        });
    });
    Array.from(document.getElementById("member-info info-card").children).forEach(el => {
        el.style.color = document.getElementById('couleur_text2').value;
    });
    document.getElementById('couleur_text2').addEventListener('input', function() {
        Array.from(document.getElementById("member-info info-card").children).forEach(el => {
            el.style.color = this.value;
        });
    });
    document.getElementById('image_logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-logo info-card').src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-logo info-card').src = 'https://dinguerie-imt.web.app/logo_bde.jpg';
        }
    });
    document.getElementById('image_background').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('svg info-card').style.display = 'none';
                document.getElementById('svg info-card').parentElement.style.backgroundImage = `url('${e.target.result}')`;
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('svg info-card').style.display = '';
            document.getElementById('svg info-card').parentElement.style.backgroundImage = '';
        }
    });
    document.getElementById('poste').addEventListener('change', function() {
        const roleElement = document.getElementById('poste info-card');
        if (this.checked) {
            roleElement.style.display = 'block';
            roleElement.textContent = 'Présidant·e';
        } else {
            roleElement.style.display = 'none';
            roleElement.textContent = '';
        }
    });
</script>

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
@endsection