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
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Organiser une passation -</h1>
		@if(Session::has('success'))
			<p class="explication">Le nouveau président à été sélectionné.</p>
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
					<p class="titre">* Président :</p>
					<p class="description">Rentrez l'uid du président. L'uid est le début de son adresse courriel étudiante (e.g. marc.bresson).</p>
					<input type="text" name="uid_president" required class="input" value="{{old('uid_president') ?? ''}}"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;">{{$creation==1 ? "TERMINER" : "VALIDER"}}</span></button>
		</form>
	</div>
</div>
@endsection