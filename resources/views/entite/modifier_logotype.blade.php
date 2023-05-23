@extends('layouts.app')

@section('titre', 'Logotype')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >

<style id="style_clair"></style>
<style id="style_sombre"></style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Ajouter un logotype</h1>
		@if(Session::has('success'))
			<p class="explication">Le logo a été modifié !</p>
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
			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Logotype :</p>
					<p class="description">Soit un svg de moins de 70ko, soit un png de ratio 1 et de plus de 512px.</p>
					<input type="file" name="logo" class="input" {{$creation==1 ? "required" : ""}} accept=".png">
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
		</form>
	</div>
</div>

<script>
body = document.getElementsByTagName('body')[0]

style_clair = document.getElementById('style_clair')
el_couleur_claire = document.getElementById("couleur_claire")
el_couleur_claire.addEventListener("change", function(){
	body.classList.toggle('light-theme', true)
	body.classList.toggle('dark-theme', false)
	style_clair.innerHTML = 'body.light-theme{--couleur_accentuation:'+ this.value +'}'
})
style_sombre = document.getElementById('style_sombre')
el_couleur_sombre = document.getElementById("couleur_sombre")
el_couleur_sombre.addEventListener("change", function(){
	body.classList.toggle('dark-theme', true)
	body.classList.toggle('light-theme', false)
	style_sombre.innerHTML = 'body.dark-theme{--couleur_accentuation:'+ this.value +'}'
})
</script>
@endsection
