@extends('layouts.app')

@section('titre', 'Ajouter un réseau social')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >

<style id="style_clair"></style>
<style id="style_sombre"></style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span> Ajouter un réseau social</h1>
		@if(Session::has('success'))
			<p class="explication">Le réseau social a été ajouté correctement.</p>
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
				<label class="input_groupe">
					<p class="titre">* Réseau social :</p>
					<select name="reseaux_sociaux_liste_id" id="reseau_social" class="input" spellcheck="false" required select="{{old('reseaux_sociaux_liste_id') ?? ''}}">
                        <option selected disabled></option>
                        @foreach ($reseaux_sociaux_existants as $reseau_social)
							<option value="{{ $reseau_social->id }}" pre_url="{{ $reseau_social->pre_url }}">{{ $reseau_social->nom }}</option>
						@endforeach
                    </select>
				</label>

				<label class="input_groupe">
					<p class="titre">* Lien :</p>
                    <div style="display:flex;">
					    <span class="pre_url"></span>
                        <input type="text" name="cle" class="input" required value="{{old('cle') ?? ''}}"/>
                    </div>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>AJOUTER</span></button>
		</form>
	</div>
</div>

<script>
    
el_reseau_social = document.getElementById("reseau_social")
el_pre_url = document.querySelector(".pre_url")
el_reseau_social.addEventListener("change", function(){
    el_pre_url.innerText = this.options[this.selectedIndex].getAttribute('pre_url');
})

</script>
@endsection
