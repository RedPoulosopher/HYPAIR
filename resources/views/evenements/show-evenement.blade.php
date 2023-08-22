@extends('layouts.app')

@section('titre', $evenement->titre)

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/post/show-post.css') }}" type="text/css" >
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
			<i id="share-btn" class="fa-solid fa-arrow-up-right-from-square"></i>
	
			{{-- @if($evenement->confidentiel)
				<p id="confidentiel" title="Ce post n'est visible que pour votre campus. Ne pas partager" class="tooltip"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Ce post est confidentiel</p>
			@endif --}}

			@php
			setlocale(LC_TIME, 'fr_FR', 'fra'); 
			@endphp

			<div class="header">
				<div class="thumbnail"><img src="{{session('entite_logo_petit')}}" alt="Logo {{$entite->nom}}"></div>
				<h1 class="title">{{$evenement->titre}}</h1>
				@if($evenement->confidentiel != 0)
					<p id="confidentiel" title="Cet évènement n'est visible que pour votre campus. Ne pas partager" class="tooltip"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Cet évènement est confidentiel</p>
				@endif
				@if(strftime("%A %d %B", strtotime($evenement->temps_debut)) == strftime("%A %d %B", strtotime($evenement->temps_fin))) {{-- Si début et fin le même jour --}}
					<p><i class="fa-regular fa-calendar"></i>{{ ucwords(utf8_encode(strftime("%A %d %B de %H:%M", strtotime($evenement->temps_debut)))) . ' à ' . utf8_encode(strftime("%H:%M", strtotime($evenement->temps_fin)))}}</p>
				@else
					<p><i class="fa-regular fa-calendar-check"></i>{{ str_replace('X', 'à', ucwords(utf8_encode(strftime("%A %d %B X %H:%M", strtotime($evenement->temps_debut)))))}}</p>
					<p><i class="fa-regular fa-calendar-xmark"></i>{{ str_replace('X', 'à', ucwords(utf8_encode(strftime("%A %d %B X %H:%M", strtotime($evenement->temps_fin))))) }}</p>
				@endif
				<p><i class="fa-solid fa-location-dot"></i>{{ $evenement->lieu }}</p>
			</div>				
			
			{{-- <p><em>Nom de l'évènement :</em> {{$evenement->titre}}</p> --}}


			<div class="description">

				<p><em>Description :</em> {{$evenement->description}}</p>
				<p><em>Nombre de personnes max :</em> {{$evenement->max_participation}}</p>
				{{-- <p><em>Confidentialité :</em> 
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
				</p> --}}
				<p><em>Campus concerné{{count($evenement->campus) > 0 ? 's' : ''}} :</em> {{ ucwords(implode(", ", $evenement->campus->pluck('label')->toArray())) }}</p>
			</div>
		</div>
	</section>
</main>

@endsection

@pushonce('end-scripts')
<script>
	shareBtn = document.getElementById("share-btn")

	function copierLien(){
		navigator.permissions.query({ name: "clipboard-write" }).then((result) => {
			if (result.state === "granted" || result.state === "prompt") {
				navigator.clipboard.writeText(window.location.href);
				alert("Lien copié dans le presse-papier ")
			}
		});
	}

	shareBtn.addEventListener('click', ()=>{
		if(window.matchMedia("(max-width: 710px)").matches && navigator.share) {//Montre l'API share sur mobile si possible
			navigator.share({
				title: '{{$evenement->titre}} - HypAIR',
				text: "[Event - {{$evenement->titre}}]\nVoir sur HypAIR :",
				url: window.location.href,
			})
		}else{			
			copierLien();
		}
	})
</script>
@endpushonce