@extends('layouts.app')

@section('titre', $creation==1 ? "Créer" : "Modifier" . ' une association')

@section('content')

@php
use Carbon\Carbon;
$annee_actuelle = Carbon::now()->format("Y");
@endphp

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >

<style id="style_clair"></style>
<style id="style_sombre"></style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> {{$creation==1 ? "Créer" : "Modifier"}} une association -</h1>
		@if(Session::has('success'))
			<p class="explication">L'association a été modifiée correctement !</p>
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
					<p class="titre">* Sites :</p>
					<p class="description">Les sites sur lesquels l'association est présente. Ctrl + clic pour sélectionner plusieurs sites.</p>
					<select name="sites[]" class="input" spellcheck="false" multiple required select_mutliple="{{old('sites') ?? $association->sites ?? ''}}" style="overflow-y: auto;">
                        <option value="douai">Douai</option>
                        <option value="dunkerque">Dunkerque</option>
                        <option value="lille">Lille</option>
                        <option value="valenciennes">Valenciennes</option>
                    </select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Description courte :</p>
					<textarea name="description_courte" class="input" required rows="8">{{old('description_courte') ?? $association->description_courte ?? ''}}</textarea>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Description :</p>
					<p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea name="description_md" class="input" required rows="8">{{old('description_md') ?? $association->description_md ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">* Catégories :</p>
					<input type="text" name="categories" class="input" required value="{{old('categories') ?? implode(", ",json_decode($association->categories ?? '[]'))}}"/>
				</label>
			</div>


			<div class="groupe ombre_petite">

				<label class="input_groupe flex">
					<p class="titre">* Privée ?</p>
					<input type="checkbox" name="privee" class="input" {{old('privee') ?? $documentation->privee ?? '' ? "checked" : ""}}/>
				</label>
				
				<label class="input_groupe flex">
					<p class="titre">* Ouverte aux membres ?</p>
					<input type="checkbox" name="ouvert" class="input" {{old('ouvert') ?? $documentation->ouvert ?? '' ? "" : "checked"}}/>
					<p class="description">Certaines associations, listes ou bureaux peuvent ne pas accepter qu'un utilisateur puisse se déclarer membre.</p>
				</label>

				<label class="input_groupe">
					<p class="titre">* Année de création :</p>
					<input type="number" name="annee_creation" class="input" required min="1980" max="{{ $annee_actuelle }}" value="{{old('annee_creation') ?? $association->annee_creation ?? $annee_actuelle}}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">Année de fin :</p>
					<input type="number" name="annee_fin" class="input" min="1980" max="{{ $annee_actuelle }}" value="{{old('annee_fin') ?? $association->annee_fin ?? ''}}"/>
				</label>
			</div>

			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">Courriel :</p>
					<p class="description">Certaines associations possèdent un compte courriel fourni par la DISI.</p>
					<input type="text" name="courriel" class="input" value="{{old('courriel') ?? $association->courriel ?? ''}}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">Alias :</p>
					<p class="description">Certaines associations ont un alias, qui rédirige les courriels vers les membres indiqués à la DISI.</p>
					<input type="text" name="alias" class="input" value="{{old('alias') ?? $association->alias ?? ''}}"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<div style="float:right; display:flex;gap:10px;">
				@if ($creation==0)
				<a class="bouton secondaire" href="/association/logotype/{{request('asso_id')}}"><span>Changer le logotype</span></a>
				@endif
				<button type="submit" class="bouton primaire"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
			</div>
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

document.querySelectorAll("select[select]").forEach(function(ceci){
	to_select = ceci.getAttribute("select");
	ceci.querySelector('[value="'+ to_select +'"]').setAttribute("selected","true")
})
</script>
@endsection