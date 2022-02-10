@extends('layouts.app')

@section('title','Accueil')

@section('content')

<link rel="stylesheet" href="css/accueil.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="grand">
		@includeFirst(['accueils.' . Request::route('uid_asso'), 'accueils.#defaut'])
	</div>
</div>
	
@endsection