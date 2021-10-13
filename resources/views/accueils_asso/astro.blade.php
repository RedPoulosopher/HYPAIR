@extends('layouts.accueil_asso')

@section('accueil_asso')

<h1>- ACTUALITÉS -</h1>
<div style="margin:70px 0px;">
	<div class="centre-element">
		<a href="/commande"><div class="bouton primaire icon-after-document ombre_petite"><span>Passer une commande de câble / adaptateur</span></div></a>
	</div>
</div>

<h1>- NOS PROJETS -</h1>
<div class="centre-element centre-enfant">
	<div class="projet ombre_inset fond">
		<span>Faire le site internet de l'AIR.</span>
		<a class="voir-plus" href="#">+</a>
	</div>
	<div class="projet ombre_inset fond">
		<span>Newsletter hebdo avec les posts facebook important.</span>
		<a class="voir-plus" href="#">+</a>
	</div>
	<div class="projet ombre_inset fond">
		<span>Remise en place d'un serveur de stockage pour les archives, les logiciels crackés, les serveurs de jeux. ça passe ou pas ?</span>
		<a class="voir-plus" href="#">+</a>
	</div>
	<div class="projet ombre_inset fond">
		<span>Courr'imt : Notification de courrier par OCR avec un raspberrypi et openCV.</span>
		<a class="voir-plus" href="#">+</a>
	</div>
	<div class="projet ombre_inset fond">
		<span>GPS pour la MEUD (quelle chambre est où).</span>
		<a class="voir-plus" href="#">+</a>
	</div>
	<div class="projet ombre_inset fond">
		<span>Webscrapping pour récupérer les vidéos de Just Dance (2 parties indépendantes).</span>
		<a class="voir-plus" href="#">+</a>
	</div>
</div>

<h1>- NOS MEMBRES -</h1>
<div class="membres centre-element centre-enfant">
	<div>
		<div class="photo centre-element">
			<div class="cercle" style="border-color: rgb(240, 20, 20)"></div>
			<img class="ombre_petite" src="images/photo_membres/marc.png"/>
		</div>
		<div class="info" style="text-align:center;">
			<span>Mathieu Constant</span>
			<br>
			<span>Président</span>
		</div>
	</div>

	<div>
		<div class="photo centre-element">
			<div class="cercle" style="border-color: rgb(240, 20, 20)"></div>
			<img class="ombre_petite" src="images/photo_membres/benjamin.png"/>
		</div>
		<div class="info" style="text-align:center;">
			<span>Marc Bresson</span>
			<br>
			<span>Vice-Président</span>
		</div>
	</div>
</div>
<div class="bouton tertiaire ombre_petite centre-element" style="display:none"><span>VOIR PLUS</span></div>

@endsection