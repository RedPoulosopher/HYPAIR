@extends('layouts.vide')

@section('titre','Connexion')

@section('content')
<link rel="stylesheet" href="/css/connexion.css" type="text/css" >

<div class="panneau ombre_grande">

	<div class="panneau_gauche connexion">
		<form action="/connexion" method="post">
            @csrf
            <h1 class="titre">Bienvenue !</h1>
            <p class="description">Connectez-vous à l'ensemble du site associatif de l'IMT Nord Europe avec votre adresse courriel étudiante.</p>
            @error('uid')
            <div class="texte-petit alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="input_groupe">
                <label for="uid" class="input-label">Identifiant</label>
                <input type="text" name="uid" id="uid" placeholder="Identifiant" class="@error('uid') is-invalid @enderror" value="{{ old('uid') }}">
            </div>
            @error('password')
            <div class="texte-petit alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="input_groupe">
                <label for="password" class="input-label">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" class="@error('password') is-invalid @enderror">
            </div>
            <div class="groupe_boutons">
				<a href="#" class="texte_petit mdp_oublie" onclick="mdp_oublie()">Mot de passe oublié ?</a>
                <button class="bouton primaire" type="submit" onclick="verif_mdp()">Connexion</button>
            </div>
        </form>
	</div>

	<div class="panneau_gauche mdp_oublie" style="display:none;">
			<h1 class="titre">Mot de passe oublié</h1>
			<p class="description">Renseignez votre adresse mail étudiante pour recevoir un lien de réinitialisation de mot de passe.</p>
			<div class="input_groupe">
				<label for="courriel" class="input-label">Courriel</label>
				<input type="courriel" name="courriel" id="courriel" placeholder="Courriel">
			</div>
			<div class="groupe_boutons">
				<a href="#" class="texte_petit" onclick="mdp_souvenu()">Retour</a>
				<button class="bouton primaire" onclick="mdp_envoie()">Envoyer</button>
			</div>
	</div>

	<div class="panneau_gauche mdp_envoye" style="display:none;">
			<h1 class="titre">courriel envoyé !</h1>
			<p class="description">Vous devrez recevoir votre courriel sous peu.<br>à bientôt !</p>
	</div>

	<div class="panneau_droite">
        <img src="images/logo_air.png" alt="">
        <span class="nom">AIR</span>
	</div>
</div>

<script>
function mdp_oublie(){
	document.querySelector('.panneau_gauche.connexion').style.display = 'none';
	document.querySelector('.panneau_gauche.mdp_oublie').style.display = 'block';
}
function mdp_souvenu(){
	document.querySelector('.panneau_gauche.mdp_oublie').style.display = 'none';
	document.querySelector('.panneau_gauche.connexion').style.display = 'block';
}

function mdp_envoie(){
	document.querySelector('.panneau_gauche.mdp_oublie').style.display = 'none';
	document.querySelector('.panneau_gauche.mdp_envoye').style.display = 'block';
}

function verif_mdp(){
	document.querySelector('.panneau_droite img').classList.add('respiration');
	document.querySelector('.texte_petit.mdp_oublie').style.opacity = '0';
	document.querySelector('.groupe_boutons .bouton.primaire').innerText = 'Connexion ...';
}
</script>

@endsection