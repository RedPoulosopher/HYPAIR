@extends('layouts.vide')

@section('titre','Cookies')

@section('content')
<link rel="stylesheet" href="/css/connexion.css" type="text/css" >

<div class="panneau ombre_grande">
	<div class="panneau_gauche" id="cookies">
		<h1 class="titre">Cookies</h1>
		<p class="description">Ce site n'affiche aucune pub, et ne se sert pas de cookie pour suivre vos usages. Les seuls cookies utilisés sont ceux qui nous sont nécessaires. <a href="#" class="texte_petit" onclick="afficher('utilisation_cookies')" style="text-decoration:underline;">en savoir plus</a>.</p>

		<div class="groupe_boutons">
			<a href="#" class="texte_petit" onclick="afficher('pas_consentir')">Ne pas consentir</a>
			<button class="bouton primaire" onclick="consentir()">Compris</button>
		</div>
	</div>

	<div class="panneau_gauche" style="display:none;" id="utilisation_cookies">
		<h1 class="titre">Cookies</h1>
		<p class="description">Les cookies nous servent uniquement à nous souvenir de vous, pour que vous n'ayez pas besoin de retaper votre mot de passe à chaque connexion.</p>
		<div class="groupe_boutons">
			<a href="#" class="texte_petit" onclick="afficher('cookies')">Retour</a>
			<button class="bouton primaire" onclick="consentir()">Compris</button>
		</div>
	</div>

	<div class="panneau_gauche" style="display:none;" id="pas_consentir">
		<h1 class="titre">Cookies</h1>
		<p class="description">En fait, on s'est mal compris. Tu n'as pas vraiment le choix, sinon le site ne fonctionne plus correctement. Pourquoi tu cherches à nous embrouiller comme ça ?</p>
		<div class="groupe_boutons">
			<a href="#" class="texte_petit" onclick="afficher('cookies')">Retour</a>
			<button class="bouton primaire" onclick="consentir()">Compris</button>
		</div>
	</div>

	<div class="panneau_droite">
        <img src="images/logo_air.png">
        <span class="nom">AIR</span>
	</div>
</div>

<script>
panneaux_information = document.querySelectorAll('.panneau_gauche')
function afficher(panneau_id){
	panneaux_information.forEach(element => {
		element.style.display = "none"
	});
	document.getElementById(panneau_id).style.display = 'block';
}
</script>

@endsection