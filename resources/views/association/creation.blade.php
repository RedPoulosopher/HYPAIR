@extends('layouts.app')

@section('titre', 'Créer une association')

@section('content')

@php
use Carbon\Carbon;
$annee_actuelle = Carbon::now()->format("Y");
@endphp

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer une nouvelle association -</h1>
		@if(Session::has('success'))
			<p class="explication">L'association a été créée correctement ! Elle est disponible.</p>
		@endif
		<form method="POST">
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
					<input type="text" name="uid_president" class="input" value="{{old('uid_president') ?? ''}}"/>
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
					<p class="description">Certaines associations ont un alias, qui rédirige les courriels vers les membres qu'on indique à la DISI.</p>
					<input type="text" name="alias" class="input" value="{{old('alias') ?? $association->alias ?? ''}}"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>{{$association->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
		</form>
	</div>
</div>

<script>
document.querySelectorAll("select[select]").forEach(function(ceci){
	to_select = ceci.getAttribute("select");
	ceci.querySelector('[value="'+ to_select +'"]').setAttribute("selected","true")
})
</script>
@endsection