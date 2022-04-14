@extends('layouts.app')

@section('titre','Even - '.$evenement->titre)

@section('content')

<style>
.documentation {
	width:100%;
	background:var(--gris_2);
	padding:25px;
	border-radius:25px;
	box-sizing:border-box;
	border:1px solid var(--gris_1);
	box-sizing: ;
}
h1.titre {
	margin-block-start:0;
	text-decoration:underline;
	text-decoration-color: var(--couleur_accentuation);
}
h1.titre::first-letter {
	text-transform: capitalize;
}
p {
	color: var(--couleur_police_secondaire);
	text-align:justify;
}
</style>
	
<div id="wrapper">
	<div id="contenu" class="petit">

		<div style="display:flex;">
			@if (substr(url()->previous(), -13)=="evenement")
			<a onclick="history.go(-1)" class="bouton secondaire ombre_petite" style="margin:15px;">< Retour</a>
			@else
			<a href="/evenement" class="bouton secondaire ombre_petite" style="margin:15px;">< Retour</a>
			@endif

			@if($gerer_evenement)
			<a href="/evenement/modifier/{{$evenement->id}}" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
			@endif
		</div>

		<div class="documentation ombre_petite">
			<div class="contenu_doc" id="contenu_doc">
		
				<h1 class="titre">{{$evenement->titre}}</h1>

				<div class="documentation ombre_petite">
					<p class="titre">Description : {{$evenement->description}}</p>
					<p class="titre">{{$evenement->temps_debut}}</p>
					<p class="titre">{{$evenement->temps_fin}}</p>
					<p class="titre">{{$evenement->lieu}}</p>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	evenement.querySelectorAll(".evenement a").forEach(ceci => ceci.classList.toggle("couleur", true))
</script>
@endsection