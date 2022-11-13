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
		cursor: pointer;
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

#modal_info_membre {
	display:none;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translateY(-50%) translateX(-50%);
	box-sizing: border-box;
	width: 95%;
	height: 95%;
	max-width: 110ch;
	max-height: 50ch;
	z-index: 11;
  border-radius: 20px;
  background: var(--couleur_fond);
	box-shadow: var(--ombre_grande);
}

#profil {
	display:grid;
	padding: 50px;
	overflow: auto;
}

#close_modal {
	position: absolute;
	padding: 5px;
	font-size: 1.5em;
	top: 20px;
	left: 20px;
	background: var(--couleur_fond);
	border-radius: 5px;
	cursor: pointer;
}

.profil {
  margin-top: auto;
	margin-bottom: auto;
  display:none;
  flex-direction:row;
  flex-wrap:wrap;
  row-gap:40px;
  column-gap: 30px;
}

.photo_profil {
	max-width:260px;
	max-height:260px;
  margin-left: auto;
  margin-right: auto;
}
.photo_profil img {
	width:100%;
	border-radius:300px;
}

.info_profil {
  display:flex;
  flex-direction:column;
  flex-grow:4;
  flex-basis:40ch;
  row-gap:20px;
}

.prenoms {
  display:flex;
  flex-direction:row;
  align-items:center;
  flex-wrap:wrap;
  gap:5px;
}

.prenoms h2 {
  margin-top:0px;
  margin-bottom:0px;
}

.prenoms .pronoms {
  color:grey;
  font-weight:normal;
}

.bio {
	max-width: 80ch;
	text-align: justify;
	overflow-wrap: break-word;
}

.reseaux_sociaux_profil {
	margin-top: 12px;
	gap: 12px;
}
.reseaux_sociaux_profil > a {
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
				<div class="photo centre-element" title="Voir le profil" tabindex="0" onclick="afficher_info_membre({{$mandat_user->id}})">
					<div class="cercle"></div>
					<img class="ombre_petite" src="{{$mandat_user->lien_photo}}" alt="Photo de profil de {{$mandat_user->prenom . " " . $mandat_user->nom}}"/>
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

<div id="modal_info_membre">
	<span id="close_modal" class='icon-close-square' tabindex="0" onclick="fermer_info_membre()"></span>
	<div id="profil">
		@foreach ($mandat as $mandat_user)
		<div id="profil_{{$mandat_user->id}}" class="profil">
			<div class="photo_profil">
				<img src="{{$mandat_user->lien_photo_utilisateur}}" alt="Votre photo de profil"/>
			</div>
				<div class="info_profil">
					<div class="prenoms">
						<h2>{{$mandat_user->user_info->prenom . " " . $mandat_user->user_info->nom}}</h2>
						@if ($mandat_user->user_info->pronom !== '')
							<h2 class="pronoms">•</h2>
							<h2 class="pronoms">{{$mandat_user->user_info->pronom}}</h2>
						@endif
					</div>
					<div class="bio">
						{!! nl2br(e($mandat_user->user_info->bio)) !!}
					</div>
					<div class="reseaux_sociaux_profil grille-enfants">
						@foreach ($mandat_user->reseaux_sociaux as $reseau_social_user)
							<a target="_blank" class="ombre_petite" href="{{ $reseau_social_user->liste->pre_url . $reseau_social_user->cle }}" style="background-color:{{ $reseau_social_user->liste->couleur }}; color:{{ $reseau_social_user->liste->couleur_police }};">
								{{ $reseau_social_user->liste->nom }}
							</a>
						@endforeach
				</div>
			</div>
		</div>
	@endforeach
</div>
</div>

@endsection

<script>

var modal_info_membre;
var current = null;

window.onload = init;

function init() {
	modal_info_membre = document.getElementById("modal_info_membre");
};


function afficher_info_membre(user_id) {
	modal_info_membre.style.display = "grid";
	if (current != user_id) {
		if (current != null) {document.getElementById("profil_"+current).style.display = "none";};
		current = user_id;
		document.getElementById("profil_"+user_id).style.display = "flex";
	};
};

function fermer_info_membre() {
	modal_info_membre.style.display = "none";
};

</script>
