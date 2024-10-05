@extends('layouts.app-without-sidebar')

@section('titre', $creation==1 ? "Créer" : "Modifier" . ' une entité')

@pushonce('styles')
	@vite([
		'resources/css/formulaire.scss',
		'resources/css/documentation.scss',
		'resources/css/entite/modifier_infos.scss',
	])
@endpushonce

@section('content')

@php
use Carbon\Carbon;
$annee_actuelle = Carbon::now()->format("Y");
@endphp

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> {{$creation==1 ? "Créer" : "Modifier"}} une entite</h1>
		@if(Session::has('success'))
			<p class="explication">L'entite a été modifiée correctement !</p>
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
				{{-- Masqué car plus d'intérêt depuis HypAIR V2 --}}
				{{-- <label class="input_groupe flex">
					<p class="titre">* Privée ?</p>
					<input type="checkbox" name="privee" class="input" {{old('privee') ?? $documentation->privee ?? '' ? "checked" : ""}}/>
				</label>
				
				<label class="input_groupe flex">
					<p class="titre">* Ouverte aux membres ?</p>
					<input type="checkbox" name="ouvert" class="input" {{old('ouvert') ?? $documentation->ouvert ?? '' ? "" : "checked"}}/>
					<p class="description">Certaines entites, listes ou bureaux peuvent ne pas accepter qu'un utilisateur puisse se déclarer membre.</p>
				</label> --}}

				<label class="input_groupe">
					<p class="titre">* Année de création :</p>
					<input type="number" name="annee_creation" class="input" required min="1980" max="{{ $annee_actuelle }}" value="{{old('annee_creation') ?? $entite->annee_creation ?? $annee_actuelle}}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">Année de fin :</p>
					<input type="number" name="annee_fin" class="input" min="1980" max="{{ $annee_actuelle }}" value="{{old('annee_fin') ?? $entite->annee_fin ?? ''}}"/>
				</label>
			</div>

			<div class="groupe card">
				<label class="input_groupe">
					<p class="titre">Courriel :</p>
					<p class="description">Certaines entites possèdent un compte courriel fourni par la DISI.</p>
					<input type="text" name="courriel" class="input" value="{{old('courriel') ?? $entite->courriel ?? ''}}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">Alias :</p>
					<p class="description">Certaines entites ont un alias, qui rédirige les courriels vers les membres indiqués à la DISI.</p>
					<input type="text" name="alias" class="input" value="{{old('alias') ?? $entite->alias ?? ''}}"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<div style="float:right; display:flex;gap:10px;">
				<button type="submit" class="bouton primaire"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
			</div>
		</form>
	</section>
</main>
@endsection
