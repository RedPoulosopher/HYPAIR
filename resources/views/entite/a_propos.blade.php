@extends('layouts.app')

@section('titre', 'A propos de '.$entite->nom)

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
	max-width: 80ch;
	text-align: justify;
	margin-left: auto;
    margin-right: auto;
	overflow-wrap: break-word;
}

.membres > div {
    position: relative;
}
.membres .photo {
    position: relative;
	width: fit-content;
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
	border-color: var(--couleur_accentuation);
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

.reseaux_sociaux {
	gap: 12px;
	margin-bottom:25px;
}
.reseaux_sociaux > a {
	padding: 10px 18px;
	border-radius: 50px;
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
				@foreach ($categories as $categorie)
					<span>#{{$categorie->label}}</span>
				@endforeach
			</div>
		@endif
		<div class="description">
			{!! Str::markdown($entite->description_md ?? $entite->description_courte ?? "") !!}
		</div>
		<div class="reseaux_sociaux grille-enfants">
			@foreach ($reseaux_sociaux as $reseau_social)
				<a target="_blank" class="ombre_petite" href="{{ $reseau_social->liste->pre_url . $reseau_social->cle }}" style="background-color:{{ $reseau_social->liste->couleur }}; color:{{ $reseau_social->liste->couleur_police }};">
					{{ $reseau_social->liste->nom }}
				</a>
			@endforeach
		</div>

		<h1 class="espace">- mandat -</h1>
		<div class="membres grille-enfants">
		@foreach ($mandat as $mandat_user)
			<div>
				<div class="photo centre-element" title="identicône par Marc Bresson">
					<div class="cercle"></div>
					<img class="ombre_petite" src="{{$mandat_user->lien_photo}}" title="identicône par Marc Bresson"/>
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
