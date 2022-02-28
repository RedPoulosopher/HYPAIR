@extends('layouts.app')

@section('titre','Doc - '.$documentation->titre)

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
			@if (substr(url()->previous(), -13)=="documentation")
			<a onclick="history.go(-1)" class="bouton secondaire" style="margin:15px;">< Retour</a>
			@else
			<a href="/documentation" class="bouton secondaire" style="margin:15px;">< Retour</a>
			@endif

			@if($gerer_documentation)
			<a href="/documentation/modifier/{{$documentation->id}}" class="bouton tertiaire icon-security-safe" style="margin:15px;">Modifier</a>
			@endif
		</div>

		<div class="documentation ombre_petite">
			<div class="contenu_doc" id="contenu_doc">
		
				<h1 class="titre">{{$documentation->titre}}</h1>

				{!! Str::markdown($documentation->contenu_md); !!}
			</div>
		</div>
	</div>
</div>

<script>
	document.querySelectorAll(".documentation a").forEach(ceci => ceci.classList.toggle("couleur", true))
</script>
@endsection