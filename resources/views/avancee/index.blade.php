@extends('layouts.app')

@section('titre', $projet->titre)

@section('content')
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >
<style>
.documentation {
	width:100%;
	background:var(--gris_2);
	padding:25px;
	border-radius:25px;
	box-sizing:border-box;
	border:1px solid var(--gris_1);
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
			<a href="../projet" class="bouton secondaire" style="margin:15px;">< Retour</a>

			@if($gerer_projet)
			<a href="../projet/{{$projet->id}}/modifier" class="bouton tertiaire icon-security-safe" style="margin:15px;">Modifier</a>
			<a href="{{$projet->slug}}/avancee/nouvelle" class="bouton tertiaire ombre_petite icon-security-safe" style="margin:15px;">Ajouter une avancée</a>
			@endif
		</div>

		<div class="documentation ombre_petite">
			<div class="contenu_doc" id="contenu_doc">
				<p>
					<h4 style="width:70%">Créé le <span>{{$creation_date}}</span>
					<span class="date" style="position:absolute;margin-left:26%;"> Deadline: {{ $projet->date_fin}}</span>
					</h4>
				</p>
				
				<p>
					<h4 class="derniere_maj" style="width:50%">Dernière mise à jour <span>{{$modification_date}}</span>
					<span class="derniere_maj" style="position:absolute;margin-left:20%;">Temps restant: <span>{{$temps_restant}} jour(s)</span>
					</span>
					</h4>
				</p>
				<h1 class="titre">{{$projet->titre}}</h1>
				{!! $converter->convert($projet->description_courte); !!}
			</div>
		</div>
		<h3 class="titre">Les avancées</h3>
		<div id="index_docs">
		@foreach ($avancees as $avancee)
			<div>
				<a class="documentation_liste"href="{{$projet->slug}}/avancee/{{ $avancee->slug }}">
					<span class="titre" style="width:75%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;">{{ $avancee->titre }}</span> 
					<span class="date" style="position:relative;">ajouté le {{ $avancee->updated_at->format('Y-m-d')}}</span>
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
