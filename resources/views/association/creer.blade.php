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
		<h1>- <span class="icon-security-safe" title="page réservée aux administrateurs"></span> Créer une nouvelle association -</h1>
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
					<input type="text" name="nom" class="input" required value="{{old('nom') ?? $association->nom ?? ''}}"/>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Bureau de ratachement :</p>
					<select name="bureau_de_ratachement" class="input" spellcheck="false" required select="{{old('bureau_de_ratachement') ?? $association->bureau_de_ratachement ?? ''}}">
                        <option selected disabled="disabled"></option>
                        <option value="bda">BDA</option>
                        <option value="bde">BDE</option>
                        <option value="bdh">BDH</option>
                        <option value="bds">BDS</option>
                    </select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Type :</p>
					<select name="type" class="input" spellcheck="false" required select="{{old('type') ?? $association->type ?? ''}}">
                        <option selected disabled="disabled"></option>
                        <option value="bureau">Bureau</option>
                        <option value="comité">Comité</option>
                        <option value="fakeliste">Fausse liste</option>
                        <option value="liste">Liste</option>
                    </select>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>SUIVANT</span></button>
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