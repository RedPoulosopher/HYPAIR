@extends('layouts.app')

@section('titre', $projet->titre)

@section('content')
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >
<style>
.documentation {
	width:100%;
	background:var(--dark-grey);
	padding:25px;
	border-radius:25px;
	box-sizing:border-box;
	border:1px solid var(--grey);
}
h1.titre {
	margin-block-start:0;
	text-decoration:underline;
	text-decoration-color: var(--couleur_accentuation);
}
h3.titre {
	margin-block-start:0;
	text-decoration:underline;
	text-decoration-color: var(--couleur_accentuation);
}
h1.titre::first-letter {
	text-transform: capitalize;
}
p {
	text-align:justify;
}
.derniere_maj {
	font-size:0.9em;
	color: var(--couleur_police_secondaire);
}
.heading-permalink {
  visibility: hidden;
}
.align-items{
	display:flex;
	justify-content: space-between;
	
}

@media only screen and (max-width: 530px) {
    .align-items{
		flex-direction: column;
		justify-content: flex-start;
	}
}
</style>

@php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\MarkdownConverter;

// Define your configuration, if needed
$config = [
	'heading_permalink' => [
        'html_class' => 'heading-permalink',
        'insert' => 'after',
		'id_prefix' => '',
        'fragment_prefix' => '',
    ],
];

// Configure the Environment with all the CommonMark parsers/renderers
$environment = new Environment($config);
$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new HeadingPermalinkExtension());

// Instantiate the converter engine and start converting some Markdown!
$converter = new MarkdownConverter($environment);
@endphp

<div id="wrapper">
	<div id="contenu" class="petit">

		<div class="align-items">
			<a href="../projet" class="bouton secondaire" style="margin:15px;">< Retour</a>

			@if($gerer_projet)
			<a href="../projet/{{$projet->id}}/modifier" class="bouton tertiaire icon-security-safe" style="margin:15px;">Modifier</a>
			<a href="{{$projet->slug}}/avancee/nouvelle" class="bouton tertiaire ombre_petite icon-security-safe" style="margin:15px;">Ajouter une avancée</a>
			@endif
		</div>

		<div class="documentation ombre_petite">
			<div class="contenu_doc" id="contenu_doc">
				<p>Chef de projet: {{ $chef_projet_prenom }} {{ $chef_projet_nom }}</p>
				<h1 class="titre">{{$projet->titre}}</h1>
				<div class="align-items" style="height: 1%">
					<div class="box">
						<h4>Créé le {{$creation_date}}</h4>
						<h6 class="derniere_maj">Dernière mise à jour {{$modification_date}}</h4>	
					</div>
					<div class="box">
						<h4 class="date">Deadline: {{ $projet->date_fin}}</h4>
						<h6 class="derniere_maj">Temps restant: {{$temps_restant}} jour(s)</h4>	
					</div>
				</div>
				<h4>Description</h4>
				{!! $converter->convert($projet->description_courte); !!}
			</div>
		</div>
		<h3 class="titre">Les avancées</h3>
		<div id="index_docs">
		@foreach ($avancees as $avancee)
			<div>
				<a class="documentation_liste align-items" href="{{$projet->slug}}/avancee/{{ $avancee->slug }}">
					<span class="titre" style="width:75%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;">{{ $avancee->titre }}</span> 
					<span class="date">ajouté le {{ $avancee->updated_at->format('Y-m-d')}}</span>
				</a>
			</div>
		@endforeach
		
		</div>
	</div>
</div>
	
		

<script>
	document.querySelectorAll(".projet a").forEach(ceci => ceci.classList.toggle("couleur", true))
</script>
@endsection
