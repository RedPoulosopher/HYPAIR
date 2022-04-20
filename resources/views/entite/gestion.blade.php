@extends('layouts.app')

@section('titre', 'Gestion de l\'entite')

@section('content')

<style>
.logo {
	position: relative;
	display: block;
	margin-left:auto;
	margin-right:auto;
	width:220px;
	height:220px;
}
.logo img {
	width:100%;
	border-radius:300px;
}
.logo a:before {
	position: absolute;
	z-index: 2;
	top:170px;
	left:170px;
	padding:10px;
	font-size:20px;
	border-radius:100px;
	background: var(--couleur_fond);
}
.description {
	margin-top:40px;
}
.conteneur_boutons {
	margin-top:40px;
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap:20px;
}
.gros_bouton {
	width:200px;
	height:200px;
	border: 1px solid var(--gris_1);
	border-radius: 15px;
	display: flex;
	justify-content: center;
	align-items: center;
	box-sizing: border-box;
    padding: 10px;
	text-align: center;
	background: var(--gris_3);
	transition: background 0.15s ease-in-out;
}
.gros_bouton:hover {
	background: var(--gris_2);
}
</style>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1>- <span class="icon-security-safe" title="page réservée aux administrateurs"></span> Gestion de l'entite -</h1>
		<div class="logo">
			<img src="{{session("entite_logo_petit")}}" alt="logo"/>
			<a class="icon-edit-2" title="Modifier le logo et les couleurs." href="hypair.imt-ne.fr/air/contact?sujet='demande de modification du logo ou des couleurs'"></a>
		</div>
		<div class="conteneur_boutons">
			<a class="gros_bouton" href="entite/modifier/description">Modifier les descriptions et catégories</a>
			<a class="gros_bouton" href="hypair.imt-ne.fr/air/contact?sujet='demande de modification du logo ou des couleurs'">Modifier le logo et les couleurs</a>
			<a class="gros_bouton" href="entite/membres">Gérer les membres</a>
			<a class="gros_bouton" href="entite/reseau_social">Gérer les réseaux sociaux</a>
			@if ($entite["type"]=="bureau" || $entite["uid"]=="air")
				<a class="gros_bouton" href="entites/admin">Gérer les entites</a>
			@endif
		</div>
	</div>
</div>
@endsection
