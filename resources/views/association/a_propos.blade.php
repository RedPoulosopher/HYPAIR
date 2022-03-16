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
.description {
	margin-top:40px;
}
</style>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1 class="titre_page">- à propos -</h1>
		<div class="logo">
			<img src="{{session("association_logo_petit")}}" alt="logo"/>
		</div>
		<div class="description">
			{!! Str::markdown($asso->description); !!}
		</div>
	</div>
</div>
@endsection
