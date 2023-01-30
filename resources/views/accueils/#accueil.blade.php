{{-- Maybe it's a useless file --}}

@extends('layouts.app')

@section('titre','Accueil')

@section('content')

<link rel="stylesheet" href="/css/accueil.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="moyen">
		@includeFirst(['accueils.' . Request::route('entite_uid'), 'accueils.#defaut'])
	</div>
</div>
	
@endsection