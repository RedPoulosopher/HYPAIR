@extends('layouts.app')

@section('title','Accueil')

@section('content')

<div id="wrapper">
	<div id="contenu">
		<h1>- ACTUALITÉS -</h1>
		<div style="margin:70px 0px;">
			<div class="centre-element">
				<a href="commande"><div class="bouton primaire icon-after-document ombre_petite"><span>Passer une commande de câble / adaptateur</span></div></a>
			</div>
		</div>
		
		<h1>- NOS PROJETS -</h1>
		<div class="centre-element centre-enfant">
			<div class="projet ombre_inset fond">
				<span>Finir le site internet de l'AIR</span>
			</div>
			<div class="projet ombre_inset fond">
				<span>Notification de courrier par OCR avec un raspberrypi et openCV</span>
			</div>
			<div class="projet ombre_inset fond">
				<span>GPS pour la MEUD (quelle chambre est où)</span>
			</div>
			<div class="projet ombre_inset fond">
				<span>Webscrapping pour récupérer les vidéos de Just Dance</span>
			</div>
		</div>
		
		<h1>- NOS MEMBRES -</h1>
		<div class="membres centre-element centre-enfant">
			<div>
				<div class="photo centre-element">
					<img class="ombre_petite" src="images/photo_membres/marc.png"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>Marc Bresson</span>
					<br>
					<span>Président</span>
				</div>
			</div>

			<div>
				<div class="photo centre-element">
					<img class="ombre_petite" src="images/photo_membres/benjamin.png"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>Benjamin Duchiron</span>
					<br>
					<span>Vice-Président</span>
				</div>
			</div>
			
			<div>
				<div class="photo centre-element">
					<img class="ombre_petite" src="images/photo_membres/lara.png"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>Lara Sirecki</span>
					<br>
					<span>Trésorière</span>
				</div>
			</div>
			
			<div>
				<div class="photo centre-element">
					<img class="ombre_petite" src="images/photo_membres/inconnu.png"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>Hajra Anwar Beg</span>
					<br>
					<span>Développeuse</span>
				</div>
			</div>
			
			<div>
				<div class="photo centre-element">
					<img class="ombre_petite" src="images/photo_membres/inconnu.png"/>
				</div>
				<div class="info" style="text-align:center;">
					<span>Nilavan Deva</span>
					<br>
					<span>Développeur</span>
				</div>
			</div>
		</div>
		<div class="bouton tertiaire ombre_petite centre-element" style="display:none"><span>VOIR PLUS</span></div>
	</div>
</div>
	
@endsection