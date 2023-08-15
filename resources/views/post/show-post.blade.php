@extends('layouts.app')

@section('titre', $post->titre)

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/evenements/show-evenement.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/post/show-post.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/documentation-popup.css') }}" type="text/css" />
@endpushonce

@section('content')

@php
use App\Http\Controllers\PostController;
@endphp
	
<main id="main-content">
	<section class="section-content">
		<h1>Infos du post</h1>

		<div style="display:flex;">
			<a onclick="history.back()" class="bouton secondaire ombre_petite" style="margin:0 0 15px;">< Retour</a>


			<!--
			@if($gerer_post)
			<a href="/post/modifier/{{$post->id}}" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
			@endif
-->
		</div>

		<div class="documentation card">
			<div class="contenu_doc" id="contenu_doc">

				<div class="thumbnail"><img src="{{session('entite_logo_petit')}}" alt="Logo {{$entite->nom}}"></div>
				<h2 class="title">{{$post->titre}}</h2>
				<p>Posté par {{$entite->nom}}<span class="separator">•</span> Il y a  {{ PostController::date_apparition_to_duration($post->date_apparition)}}</p>
		
				<div>{!! Str::markdown(strip_tags($post->description ?? '')) !!}</div>
			</div>
		</div>
	</section>
</main>

@endsection