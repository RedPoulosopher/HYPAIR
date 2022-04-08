@extends('layouts.app')

@section('titre', 'Gestion de l\'entite')

@section('content')

<style>
.logo {
	position: relative;
	display: block;
	margin-left:auto;
	margin-right:auto;
	width:260px;
	height:260px;
}
.logo img {
	width:100%;
	border-radius:300px;
}
.categories {
	margin-top:20px;
	color:var(--couleur_police_secondaire);
    display:flex;
    flex-wrap: wrap;
    justify-content: center;
    gap:5px;
}
.categories > span {
	background: var(--gris_1);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}
.description {
	margin-top:40px;
}

.membres > div {
    position: relative;
}
.membres .photo {
    position: relative;
}
.membres .photo img {
    border-radius: 500px;
    background: var(--gris_2);
}
.membres .photo .cercle {
    border-radius: 500px;
    border:2px solid;
    position:absolute;
    left:calc(5% - 2px);
    top:calc(5% - 3px);
    width:90%;
    height:90%;
}

@media (max-width: 767.98px) {
    .membres > div {
    margin:15px;
    }
    .membres .photo img {
    width:130px;
    height:130px;
    }
}
@media (min-width: 768px) {
    .membres > div {
    margin:20px;
    }
    .membres .photo img {
    width:180px;
    height:180px;
    }
}
</style>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1 class="titre_page">- à propos de {{$entite->nom}} -</h1>
		<div class="logo">
			<img src="{{session("entite_logo_petit")}}" alt="logo"/>
		</div>
		@if (!is_null($entite->categories))
			<div class="categories">
				@foreach (json_decode($entite->categories) as $categorie)
					<span>#{{$categorie}}</span>
				@endforeach
			</div>
		@endif
		<div class="description">
			{!! Str::markdown($entite->description_md ?? ""); !!}
		</div>

		<h1>- mandat -</h1>
		<div class="membres grille-enfants">
		@foreach ($mandat as $mandat_user)
			<div>
				<div class="photo centre-element">
					<div class="cercle" style="border-color: rgb(240, 20, 20)"></div>
					<img class="ombre_petite" src="{{$mandat_user->lien_photo}}"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>{{$mandat_user->prenom . " " . $mandat_user->nom}}</span>
					<br>
					<span>{{$mandat_user->label}}</span>
				</div>
			</div>
		@endforeach
		</div>
	</div>
</div>
@endsection
