{{-- créer un model de carte avec un form (entity_name,subtitle,color...,image_logo,image_background, check poste --}}
@extends('layouts.app-without-sidebar')
@section('titre', 'Créer une carte')
@pushonce('styles')
    @vite('resources/css/entite/card/create_card.scss')
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
        @include('entite.card.card_view', ['card' => null])
        <div class="section-content">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom de la carte :</label>
                    <input type="text" id="nom" name="nom" value="{{ $entite->nom }}" required autocomplete="off">
                    @error('nom')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="subtitle">Sous-titre :</label>
                    <input type="text" id="subtitle" name="subtitle" value="Carte adhérant" autocomplete="off">
                    @error('subtitle')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="coulor1">Couleur 1 :</label>
    				<input type="color" name="couleur1" class="input" required id="couleur1" value="{{old('couleur1') ?? $entite->couleur_claire ?? '#ffffffff'}}">
                </div>
                <div class="form-group">
                    <label for="coulor2">Couleur 2 :</label>
    				<input type="color" name="couleur2" class="input" required id="couleur2" value="{{old('couleur2') ?? $entite->couleur_sombre ?? '#ffffffff'}}">
                </div>
                <div class="form-group">
                    <label for="coulor_text1">Couleur du texte 1 :</label>
                    <input type="color" id="couleur_text1" name="couleur_text1" required value="{{old('couleur_text1') ?? couleur_opposee($entite->couleur_claire) ?? '#000000ff'}}">
                    @error('couleur_text1')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="coulor_text2">Couleur du texte 2 :</label>
                    <input type="color" id="couleur_text2" name="couleur_text2" required value="{{old('couleur_text2') ?? couleur_opposee($entite->couleur_sombre) ?? '#000000ff'}}">
                    @error('couleur_text2')
                        <div class="error">{{ $message }}</div>
                    @enderror
                <div class="form-group">
                    <label for="image_logo">Logo (optionnel) :</label>
                    <input type="file" id="image_logo" name="image_logo" accept="image/*">
                    @error('image_logo')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image_background">Image de fond (optionnel) :</label>
                    <input type="file" id="image_background" name="image_background" accept="image/*">
                    @error('image_background')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="poste">Affichier le poste :</label>
                    <input type="checkbox" id="poste" name="poste" {{ old('poste') ? 'checked' : '' }}>
                    @error('poste')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="bouton primaire">Créer la carte</button>
            </form>
        </div>
    </section>
</main>
<script>
    document.getElementById('image-logo info-card').src = "{{ $entite->logo_url('petit') }}";
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
@endsection