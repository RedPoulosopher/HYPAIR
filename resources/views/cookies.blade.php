@extends('layouts.vide')

@section('titre','Cookies')

@section('content')
<link rel="stylesheet" href="/css/connexion.css" type="text/css" >

<div class="panneau ombre_grande">
	<div class="panneau_gauche cookies">
			<h1 class="titre">Cookies</h1>
			<p class="description">Bonjour, ce site n'affiche aucune pub, et ne se sert pas de cookie pour suivre vos usages. Les seuls cookies utilisés sont ceux qui nous sont nécessaires. <a href="#" class="texte_petit" onclick="voir_utilisation()" style="text-decoration:underline;">en savoir plus</a>. Vous devez confirmer votre choix ci-dessous.</p>

			<div class="groupe_boutons">
				<a href="#" class="texte_petit" onclick="pas_consentir()">Ne pas consentir</a>
				<button class="bouton primaire" onclick="consentir()">Consentir</button>
			</div>
	</div>

	<div class="panneau_gauche utilisation_cookies" style="display:none;">
		<h1 class="titre">Cookies</h1>
		<p class="description">Les cookies nous servent à nous souvenir de vous, pour que vous n'ayez pas besoin de retaper votre mot de passe à chaque fois.</p>
		<div class="groupe_boutons">
			<a href="#" class="texte_petit" onclick="retour()">Retour</a>
			<button class="bouton primaire" onclick="consentir()">Consentir</button>
		</div>
	</div>

	<div class="panneau_gauche pas_consentir" style="display:none;">
		<h1 class="titre">Cookies</h1>
		<p class="description">En fait, on s'est mal compris. Tu n'as pas vraiment le choix, sinon le site ne fonctionne plus correctement. Pourquoi tu cherches à nous embrouiller comme ça ?</p>
		<div class="groupe_boutons">
			<a href="#" class="texte_petit" onclick="retour()">Retour</a>
		</div>
	</div>

	<div class="panneau_droite">
		<img class="logo_air" src="images/logo_air_1.png" alt="">
	</div>
</div>

<script>
function pas_consentir(){
	document.querySelector('.panneau_gauche.cookies').style.display = 'none';
	document.querySelector('.panneau_gauche.pas_consentir').style.display = 'block';
}

function voir_utilisation(){
	document.querySelector('.panneau_gauche.cookies').style.display = 'none';
	document.querySelector('.panneau_gauche.utilisation_cookies').style.display = 'block';
}

function retour(){
	document.querySelector('.panneau_gauche.pas_consentir').style.display = 'none';
	document.querySelector('.panneau_gauche.utilisation_cookies').style.display = 'none';
	document.querySelector('.panneau_gauche.cookies').style.display = 'block';
}

function consentir(){

}
</script>

@endsection