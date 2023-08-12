@extends('layouts.app')

@section('titre', $evenement->titre)

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/evenements/show-evenement.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/documentation-popup.css') }}" type="text/css" />
@endpushonce

@section('content')

<style>

</style>
	
<main id="main-content">
	<section class="section-content">

		<div style="display:flex;">
			@if (substr(url()->previous(), -13)=="evenement")
			<a onclick="history.go(-1)" class="bouton secondaire ombre_petite" style="margin:15px;">< Retour</a>
			@else
			<a href="{{ url()->previous() }}" class="bouton secondaire ombre_petite" style="margin:15px;">< Retour</a>
			@endif

			<!--
			@if($gerer_evenement)
			<a href="/evenement/modifier/{{$evenement->id}}" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
			@endif
-->
		</div>

		<div class="documentation card">
			<div class="contenu_doc" id="contenu_doc">
		
				<h1 class="titre">{{$evenement->titre}}</h1>

				<p>Description : {{$evenement->description}}</p>
				<p>Début : {{$evenement->temps_debut}}</p>
				<p>Fin : {{$evenement->temps_fin}}</p>
				<p>Lieu : {{$evenement->lieu}}</p>
				<p>Nombre de personnes max : {{$evenement->max_participation}}</p>
				<p>Confidentialité : 
					@if ($evenement['confidentialite'] == 0)                          
                    Public
                    @elseif ($evenement['confidentialite'] == 1)
                    Membres de l'assos
                    @elseif ($evenement['confidentialite'] == 2)
                    Responsables & bureau
                    @elseif ($evenement['confidentialite'] == 3)
                    Bureau
                    @elseif ($evenement['confidentialite'] == 4)
                    Prez & vice-prez
                    @endif
				</p>
				@if ($evenement['confidentialite'] == 0)	
					<p>Statut : 
						@if ($evenement['validation'] == 1)                          
						Validé
						@elseif ($evenement['validation'] == 0)
						En attente de validation
						@endif
					</p>
				@endif
			</div>
		</div>
	</section>
</main>

@endsection