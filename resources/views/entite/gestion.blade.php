@extends('layouts.app')

@section('titre', 'Gestion de l\'entité')

@pushonce('styles')
<link rel="stylesheet" href="/css/gestion.css" type="text/css" />
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span> Gestion de l'entite</h1>
		<div class="logo">
			<img src="{{session("entite_logo_petit")}}" alt="logo"/>
			<a class="icon-edit-2" title="Modifier le logo et les couleurs." href="logotype"></a>
		</div>
		<div class="conteneur_boutons">
			<a class="gros_bouton card" href="evenement">Gérer les évènements</a>
			<a class="gros_bouton card" href="membres">Gérer les membres</a>
			<a class="gros_bouton card" href="reseau_social">Gérer les réseaux sociaux</a>
			<a class="gros_bouton card" href="description">Modifier les descriptions et catégories</a>
			<a class="gros_bouton card" href="logotype">Modifier le logo</a>
			<a class="gros_bouton card" href="couleur">Modifier les couleurs</a>
			@if ($entite["type"]=="bureau" || $entite["uid"]=="air")
				<a class="gros_bouton" href="../entites/admin">Gérer les entites</a>
			@endif
		</div>
	</section>
</main>

@endsection
