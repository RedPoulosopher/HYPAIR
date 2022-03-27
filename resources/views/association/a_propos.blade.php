@extends('layouts.app')

@section('titre', 'Gestion de l\'association')

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
</style>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1 class="titre_page">- à propos de {{$asso->nom}} -</h1>
		<div class="logo">
			<img src="{{session("association_logo_petit")}}" alt="logo"/>
		</div>
		@if (!is_null($asso->categories))
			<div class="categories">
				@foreach (json_decode($asso->categories) as $categorie)
					<span>#{{$categorie}}</span>
				@endforeach
			</div>
		@endif
		<div class="description">
			{!! Str::markdown($asso->description_md); !!}
		</div>

		<h1>- mandat -</h1>
	</div>
</div>
@endsection
