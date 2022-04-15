<div class="fenetre_contextuelle ombre_grande" id="fenetre_rgpd" style="display:none;">
	<div class="panneau" id="rgpd">
		<h1 class="titre">RGPD</h1>
		<p class="description">Notre politique de confidentialité est conçue pour vous informer de la façon dont nous <a href="#" onclick="afficher('utilisation_donnees')" style="text-decoration:underline;">utilisons vos données personnelles</a>. Nous vous expliquons également quels sont <a href="#" onclick="afficher('droits')" style="text-decoration:underline;">vos droits et la façon de les exercer</a>.
		<br><br>
		Toutes les informations sur <a href="/rgpd" style="text-decoration:underline;">hypair.imt-ne.fr/rgpd</a>.</p>
		<div class="groupe_boutons">
			<a>.</a>
			<button class="bouton primaire" onclick="consentir_rgpd()">Compris</button>
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
