@extends('layouts.app')

@section('titre', 'Créer une association')

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
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer une nouvelle association -</h1>
		@if(Session::has('success'))
			<p class="explication">L'association a été créée correctement ! Elle est disponible.</p>
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
					<p class="titre">* Nom :</p>
					<input type="text" name="nom" class="input" id="nom_asso" required value="{{old('nom') ?? $association->titre ?? ''}}"/>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Bureau de ratachement :</p>
					<select name="bureau_de_ratachement" class="input" spellcheck="false" required select="{{old('bureau_de_ratachement') ?? $association->bureau_de_ratachement ?? ''}}">
                        <option selected disabled="disabled"></option>
                        <option value="BDA">BDA</option>
                        <option value="BDE">BDE</option>
                        <option value="BDH">BDH</option>
                        <option value="BDS">BDS</option>
                    </select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Type :</p>
					<select name="type" class="input" spellcheck="false" required select="{{old('type') ?? $association->type ?? ''}}">
                        <option selected disabled="disabled"></option>
                        <option value="club">Club</option>
                        <option value="liste">Liste</option>
                        <option value="comité">Comité</option>
                        <option value="bureau">Bureau</option>
                    </select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Sites :</p>
					<p class="description">Les sites de présence de l'association. Ctrl + clic pour sélectionner plusieurs sites.</p>
					<select name="sites[]" class="input" spellcheck="false" multiple required select_mutliple="{{json_encode(old('sites')) ?? json_encode($association->sites) ?? ''}}" style="overflow-y: auto;">
                        <option value="douai">Douai</option>
                        <option value="dunkerque">Dunkerque</option>
                        <option value="lille">Lille</option>
                        <option value="valenciennes">Valenciennes</option>
                    </select>
				</label>
			</div>

			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Président :</p>
					<p class="description">Rentrez l'uid du président. L'uid est le début de son adresse courriel étudiante (e.g. marc.bresson).</p>
					<input type="text" name="uid_president" required class="input" value="{{old('uid_president') ?? ''}}"/>
				</label>
			</div>

			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Logotype :</p>
					<p class="description">Soit un svg de moins de 70ko, soit un png de ratio 1 et de plus de 512px.</p>
					<input type="file" name="logo" class="input" required accept=".png,.svg">
				</label>

				<label class="input_groupe">
					<p class="titre">* Couleur principale sur thème clair :</p>
					<input type="color" name="couleur_claire" class="input" required id="couleur_claire">
				</label>

				<label class="input_groupe">
					<p class="titre">* Couleur principale sur thème sombre :</p>
					<input type="color" name="couleur_sombre" class="input" required id="couleur_sombre">
				</label>

				<details style="margin-top:2em;">
					<summary>Afficher les tests de couleurs.</summary>
					<p>La couleur de la police sera déterminée automatiquement entre le blanc et le noir en fonction du meilleur contraste.</p>
					<h1>CECI EST TEST</h1>
					<a class="documentation_liste" href="#" style="margin-bottom:2em;">
						<div>
							<span class="icon-security" title="documentation privée"></span>
							<span class="titre">C'est juste un élément de test</span>
							<p class="contenu_md"># Comment se déroule le test ? ## changer la couleur. Pour changer la couleur, il suffit de cliquer sur le champ prévu à cet effet.</p>
							<div class="categories" raw="reseau test tech">
									<span>#reseau</span>
									<span>#test</span>
									<span>#tech</span>
							</div>
						</div>
					</a>
					<div class="bouton primaire" style="float:right;">COUCOU</div>
					<div class="bouton secondaire" style="float:right;margin-right:1em;">Coucou ?</div>
				</details>
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
			<button type="submit" class="bouton primaire" style="float:right;"><span>{{$association->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
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