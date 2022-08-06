	<div class="fenetre_contextuelle ombre_grande" id="fenetre_cookies" style="display:none;">
		<div class="panneau" id="cookies">
			<h1 class="titre">Cookies</h1>
			<p class="description">Ce site n'affiche aucune pub, et ne se sert pas de cookie pour suivre vos usages. Les seuls cookies utilisés sont ceux qui nous sont nécessaires. <a class="lien" onclick="afficher('utilisation_cookies')">en savoir plus</a>.</p>
	
			<div class="groupe_boutons">
				<a class="lien" onclick="afficher('pas_consentir')">Ne pas consentir</a>
				<button class="bouton primaire" onclick="consentir_cookies()">Compris</button>
			</div>
		</div>
	
		<div class="panneau" style="display:none;" id="utilisation_cookies">
			<h1 class="titre">Cookies</h1>
			<p class="description">Les cookies nous servent uniquement à nous souvenir de vous, pour que vous n'ayez pas besoin de retaper votre mot de passe à chaque connexion.</p>
			<div class="groupe_boutons">
				<a class="lien" onclick="afficher('cookies')">Retour</a>
				<button class="bouton primaire" onclick="consentir_cookies()">Compris</button>
			</div>
		</div>
	
		<div class="panneau" style="display:none;" id="pas_consentir">
			<h1 class="titre">Cookies</h1>
			<p class="description">En fait, on s'est mal compris. Tu n'as pas vraiment le choix, sinon le site ne fonctionne plus correctement. Pourquoi tu cherches à nous embrouiller comme ça ?</p>
			<div class="groupe_boutons">
				<a class="lien" onclick="afficher('cookies')">Retour</a>
				<button class="bouton primaire" onclick="consentir_cookies()">Compris</button>
			</div>
		</div>
	</div>
