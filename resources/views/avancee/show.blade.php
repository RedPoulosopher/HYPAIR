@extends('layouts.app')

@section('titre', $avancee->titre)

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
	text-align:justify;
}
.derniere_maj {
	font-size:0.9em;
	color: var(--couleur_police_secondaire);
}
.heading-permalink {
  visibility: hidden;
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

		<div style="display:flex;">
			<a href="../../{{$slug}}" class="bouton secondaire" style="margin:15px;">< Retour</a>

			@if($gerer_projet)
			<a href="{{$avancee->id}}/modifier" class="bouton tertiaire icon-security-safe" style="margin:15px;">Modifier</a>
			@endif
		</div>

		<div class="documentation ombre_petite">
			<div class="contenu_doc" id="contenu_doc">
		
				<h1 class="titre">{{$avancee->titre}}</h1>
				<p class="derniere_maj">Dernière mise à jour <span>{{$modification_date}}</span></p>

				{!! $converter->convert($avancee->description_md); !!}
				<a>{{$avancee->pdf}}</a>
				
			</div>
		</div>
	</div>
	
</div>

<script>
	document.querySelectorAll(".documentation a").forEach(ceci => ceci.classList.toggle("couleur", true))
</script>
@endsection
