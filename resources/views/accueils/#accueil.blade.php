@extends('layouts.app')

@section('title','Accueil')

@section('content')

<div id="wrapper">
	<div id="contenu" class="grand">
		@yield('accueil_asso')
	</div>
</div>
	
@endsection