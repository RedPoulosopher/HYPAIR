@extends('layouts.vide')

@section('titre','RGPD')

@section('content')
<link rel="stylesheet" href="/css/fenetre_contextuelle.css" type="text/css" >

<div class="fenetre_contextuelle ombre_grande">
	<div class="panneau" id="cookies">
		<h1 class="titre">RGPD</h1>
		<p class="description">Notre politique de confidentialité est conçue pour vous informer de la façon dont nous <a href="#" onclick="afficher('utilisation_cookies')" style="text-decoration:underline;">utilisons vos données personnelles</a>. Nous vous expliquons également quels sont <a href="#" onclick="afficher('utilisation_cookies')" style="text-decoration:underline;">vos droits et la façon de les exercer</a>.
		<br><br>
		Toutes les informations sur <a href="/rgpd" style="text-decoration:underline;">hypair.imt-ne.fr/rgpd</a>.</p>
		<div class="groupe_boutons">
			<a>.</a>
			<button class="bouton primaire" onclick="consentir()">Compris</button>
		</div>
	</div>
</div>

<script>
panneaux_information = document.querySelectorAll('.panneau')
function afficher(panneau_id){
	panneaux_information.forEach(element => {
		element.style.display = "none"
	});
	document.getElementById(panneau_id).style.display = 'block';
}
</script>

@endsection