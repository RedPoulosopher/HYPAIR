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
                        
                        <x-image_file :nameGrpFile="'Logo'" :alea="'logo'" :urlImg="$entite->getLogo?->url()" :displayMode="2"/>
                        
                        <x-image_file :nameGrpFile="'Arrière Plan'" :alea="'background'" :urlImg="''" :displayMode="1"/>

                        <span>* Les champs marqués d'une astérisque sont obligatoires</span>
                    </div>


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
    document.getElementById('original_input_file_logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-logo info-card').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    document.getElementById('original_input_file_background').addEventListener('change', function(event) {
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
</script>
@endsection