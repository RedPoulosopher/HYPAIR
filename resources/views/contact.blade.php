@extends('layouts.app')

@section('titre','Nous contacter')

@pushonce('styles')
<link rel="stylesheet" href="css/contact.css" type="text/css" />
@endpushonce

@section('content')

<div id="main-content" class="moyen">
	<section>

		<h1>Nous contacter</h1>
		@if(Session::has('success'))
			<p class="explication">Votre problème va être résolu ! A bientôt.</p>
		@else
			<p class="explication">Un problème ? Une question ? L'AIR peut sûrement vous aider !</p>
		@endif
		{!! Form::open() !!}
			<div class="champs_conteneur" style="width:100%;" for="courriel">
				<label class="champs flex border">
					<span class="titre">courriel :</span>
					<input id="courriel" name="email" class="input affichage_empty" spellcheck="false" required/>
				</label>
			</div>
			<div class="champs_conteneur" style="width:100%;" for="objet">
				<label class="champs flex border">
					<span class="titre">objet :</span>
					<input id="objet" name="objet" class="input affichage_empty" required/>
				</label>
			</div>
			<div class="champs_conteneur" style="width:100%;" for="requete">
				<label class="champs">
					<span class="titre">requête :</span>
					<textarea id="requete" name="message" class="affichage_empty" pattern=".{60,}" required title="au moins 60 caractères dans la réponse" rows="13"></textarea>
				</label>
			</div>
			<button type="submit" class="bouton primaire icon-after-mail ombre_petite" style="float:right;"><span>ENVOYER</span></button>
		{!! Form::close() !!}
	</section>
</div>


@endsection