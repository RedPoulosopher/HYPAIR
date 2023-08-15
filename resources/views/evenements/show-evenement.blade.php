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
		<h1>Infos de l'évènement</h1>

		<div style="display:flex;">
			<a onclick="history.back()" class="bouton secondaire ombre_petite" style="margin:0 0 15px;">< Retour</a>


			<!--
			@if($gerer_evenement)
			<a href="/evenement/modifier/{{$evenement->id}}" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
			@endif
-->
		</div>

		<div class="documentation card">
			<div class="contenu_doc" id="contenu_doc">
		
				<p><em>Nom de l'évènement :</em> {{$evenement->titre}}</p>

				<p><em>Description :</em> {{$evenement->description}}</p>
				<p><em>Début :</em> {{$evenement->temps_debut}}</p>
				<p><em>Fin :</em> {{$evenement->temps_fin}}</p>
				<p><em>Lieu :</em> {{$evenement->lieu}}</p>
				<p><em>Nombre de personnes max :</em> {{$evenement->max_participation}}</p>
				<p><em>Confidentialité :</em> 
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
					<p><em>Statut :</em> 
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