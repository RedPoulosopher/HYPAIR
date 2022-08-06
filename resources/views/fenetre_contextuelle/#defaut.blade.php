<div id="fenetres_contextuelles" style="display:none;">
    @include("fenetre_contextuelle.cookies")
    @include("fenetre_contextuelle.rgpd")
</div>

<script>
fenetres_contextuelles = document.getElementById("fenetres_contextuelles")
fenetres_affichees = []

date_cookies = localStorage.getItem("date_cookies");
if(!date_cookies || date_cookies < Date.now() - 1000*60*60*24*31*3){ //si les cookies ont pas été acceptés ou si ça fait plus de 3 mois

    fenetre_cookies = document.getElementById("fenetre_cookies")

    fenetres_affichees.push(fenetre_cookies)

    function consentir_cookies(){
        localStorage.setItem("date_cookies", Date.now());
        fenetre_cookies.style.display = "none"

        afficher_prochaine_fenetre()
    }
}

date_rgpd = localStorage.getItem("date_rgpd");
if(!rgpd || date_rgpd < Date.now() - 1000*60*60*24*31){ //si la rgpd n'a pas été acceptée ou si ça fait plus de 31 jours
    fenetre_rgpd = document.getElementById("fenetre_rgpd")

    fenetres_affichees.push(fenetre_rgpd)

    function consentir_rgpd(){
        localStorage.setItem("date_rgpd", Date.now());
        fenetre_rgpd.style.display = "none"

        afficher_prochaine_fenetre()
    }
}

function afficher_prochaine_fenetre(){
    if(fenetres_affichees.length==0){
        fenetres_contextuelles.style.display = "none"
    }
    if(fenetres_affichees.length>0){
        prochaine_fenetre = fenetres_affichees.pop()
        fenetres_contextuelles.style.display = "block"
        prochaine_fenetre.style.display = "block"
    }
}
afficher_prochaine_fenetre()

function afficher(panneau_id){
	panneaux_information = document.querySelectorAll('.panneau')
	panneaux_information.forEach(element => {
		element.style.display = "none"
	});
	document.getElementById(panneau_id).style.display = 'block';
}

</script>
