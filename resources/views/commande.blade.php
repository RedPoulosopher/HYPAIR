@extends('layouts.app')

@section('title','passer une commande - AIR')

@section('content')

<style>
@media (max-width: 767.98px) {
		#contenu{
		width:100%;
		}
}

@media (min-width: 768px) {
		#contenu{
		width:500px;
		}
}
</style>

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
		<div id="contenu">
			<h1>- Commande -</h1>
			<p class="explication">L'AIR propose de faire une commande groupée de cables et d'adaptateur afin de vous faire payer moins. Profitez-en !</p>

			<div class="champs_conteneur" style="width:100%;">
				<label class="champs border focus_elargi" for="courriel">
					<span class="titre">courriel :</span>
					<span class="input affichage_empty" id="courriel" contenteditable role="textbox" spellcheck="false"></span>
					<span>@etu.imt-lille-douai.fr</span>
				</label>
				<br>
				<label class="champs flex border focus_elargi" style="margin-top:15px;" for="telephone">
					<span class="titre">téléphone :</span>
					<span class="input affichage_empty" id="telephone" contenteditable role="textbox" spellcheck="false"></span>
				</label>
			</div>
			<div class="champs_conteneur border" style="width:100%;">
				<div class="champs radio">
					<span class="titre">quelle est votre résidence ?</span>
					<label class="">
						<input name="radio" type="radio" onchange="this.parentNode.parentNode.setAttribute('empty', false);"/>
						<span>Lavoisier</span>
					</label>
					<label class="">
						<input name="radio" type="radio" onchange="this.parentNode.parentNode.setAttribute('empty', false);"/>
						<span>Condorcet</span>
					</label>
					<label class="">
						<input name="radio" type="radio" onchange="this.parentNode.parentNode.setAttribute('empty', false);"/>
						<span>Descartes</span>
					</label>
				</div>

				<div class="champs border" style="margin-top:15px;">
					<span class="titre">quel est votre numéro de chambre ?</span>
					<br>
					<select>
						<option checked>chambre</option>
						<option>studio</option>
					</select>
					<span>N° </span>
					<span class="input affichage_empty" id="telephone" contenteditable role="textbox" spellcheck="false"></span>
				</div>
			</div>

			<div class="champs_conteneur border" style="width:100%;">
				<div class="champs border focus_elargi" for="cable">
					<span class="titre">quelle quantité de câbles RJ45 (5m) voulez-vous ? (3.50€/unité)</span>
					<span class="input affichage_empty" id="cable" contenteditable role="textbox" spellcheck="false" onkeyup="maj_prix()"></span>
				</div>
				<div class="champs border focus_elargi" for="adapt-usba" style="margin-top:15px;">
					<span class="titre">quelle quantité d'adaptateur USB A - RJ45 voulez-vous ? (3.50€/unité)</span>
					<span class="input affichage_empty" id="adapt-usba" contenteditable role="textbox" spellcheck="false" onkeyup="maj_prix()"></span>
				</div>
				<div class="champs border focus_elargi" for="adapt-usbc" style="margin-top:15px;">
					<span class="titre">quelle quantité d'adaptateur USB C - RJ45 voulez-vous ? (3.50€/unité)</span>
					<span class="input affichage_empty" id="adapt-usbc" contenteditable role="textbox" spellcheck="false" onkeyup="maj_prix()"></span>
				</div>
			</div>

			<div class="champs_conteneur border" style="width:100%;">
				<span class="titre">prix total :</span>
				<div style="float:right">
					<span id="prix">0€</span>
				</div>
			</div>

			<script>
				prix={"cable":5.99,"adapt-usbc":5.04,"adapt-usba":7.08}
				function maj_prix(){
					somme=0
					error=false
					for(i in prix){
						qtt = document.getElementById(i).innerText
						if(qtt==""){qtt=0}
						else if(isNaN(qtt)){error=true;break;}
						somme+=parseInt(qtt)*prix[i]
					}
					console.log(somme)
					if(error){document.getElementById("prix").innerText = "erreur"}
					else{document.getElementById("prix").innerText = (Math.round(somme*100)/100).toString()+"€"}
				}

				$(".focus_elargi").each(function(){
					$(this).on("click", function(){
						$("#"+this.getAttribute('for')).focus();
					})
				})

				$(".affichage_empty").each(function(){
					$(this).on("keyup", function(){
						this.parentNode.setAttribute('empty', this.innerText=='');
					})
				})
			</script>

			<div class="bouton primaire icon-after-mail ombre_petite" style="float:right;"><span>PAYER</span></div>
		</div>
	</div>
</div>

@endsection