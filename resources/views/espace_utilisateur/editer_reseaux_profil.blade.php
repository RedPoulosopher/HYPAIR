<!--
Page d'edition du profil utilisateur, peut y changer photo de profil, nom, prenom, pronoms, promo.
On voit le mail et le pseudo user associé sans pouvoir le changer.
-->

@extends('layouts.vide')

@section('titre', 'Gérer les réseaux sociaux')

@section('content')

<link rel="stylesheet" type="text/css" href="/css/jstable.css">
<link rel="stylesheet" type="text/css" href="/css/formulaire.css">

<style>
#choix_role {
    display:flex;
    justify-content:center;
    gap:10px;
    margin-top:25px;
}
div.table {
    box-sizing: border-box;
    border-radius: 25px;
    margin-top:10px;
    overflow: auto;
    padding: 13px 18px;
    border: 1px solid var(--grey);
    background-color: var(--dark-grey);
    transition: border-color 0.1s ease-in-out;
}
div.table:hover {
    border-color: var(--couleur_accentuation);
}
table {
    border-collapse: collapse;
    width:100%;
}
table tr {
    text-align:center;
    color: var(--couleur_police);
    border-bottom: 1px solid transparent;
}
table tbody tr:hover {
    border-bottom: 1px solid var(--grey);
}
table th {
    padding: 15px 15px;
    border-bottom: 1px solid var(--grey);
}
table td {
    padding: 10px 15px;
}

td span.role {
	font-size: 0.95em;
	color:var(--couleur_police_secondaire);
	background: var(--grey);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}
td.lien {
    text-align: left;
}
td a.icon-edit-2, td a.icon-trash {
    cursor:pointer;
}
</style>

<div id="contenu" class="petit">
	<h1><span class="icon-people"></span> Gestion des réseaux sociaux</h1>
	<a href="/home" class="bouton secondaire">< Retour au profil</a>

	<form method="POST">
			@csrf
			<div class="groupe ombre_petite">
					<label class="input_groupe">
							<p class="titre"><span style="color:var(--couleur_accentuation);">*</span> Réseau social :</p>
							<select name="reseaux_sociaux_liste_id" id="reseaux_sociaux_liste" class="input" spellcheck="false" required>
									<option selected disabled></option>
									@foreach ($reseaux_sociaux_existants as $reseau_social)
											<option value="{{ $reseau_social->id }}" pre_url="{{ $reseau_social->pre_url }}">{{ $reseau_social->nom }}</option>
									@endforeach
							</select>
					</label>

					<label class="input_groupe">
							<p class="titre"><span style="color:var(--couleur_accentuation);">*</span> Lien :</p>
							<div style="display:flex;gap:10px;align-items:center;">
									<span class="pre_url" style="display:none;"></span>
									<input type="text" name="cle" id="cle" class="input"/>
							</div>
					</label>
					<div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:space-between; align-items:flex-start; margin-top:15px; color:var(--couleur_police_secondaire);">
						<div style="flex-grow:1; flex-basis:20ch;">
							<p>Vous ne pouvez avoir qu'un seul réseau social de chaque type.</p>
							<p>Pour supprimer un réseau social, laissez le lien vide, et appuyez sur <i>Supprimer</i></p>
						</div>
							<button type="submit" class="bouton primaire" style="margin-left:auto; margin-top:auto;">AJOUTER</span></button>
					</div>
			</div>
	</form>

	<div class="table ombre_petite">
			<table id="index">
					<thead>
							<tr>
									<th width="35%">Nom</th>
									<th>Lien</th>
									<th width="5%">-</th>
							</tr>
					</thead>
					<tbody>
							@foreach ($reseaux_sociaux as $reseau_social)
									<tr class="ligne_membre">
											<td>{{$reseau_social->liste->nom}}</td>
											<td class="lien"><a class="couleur" href="{{$reseau_social->liste->pre_url.$reseau_social->cle}}">{{$reseau_social->liste->pre_url.$reseau_social->cle}}</a></td>
											<td><a class="modifier_reseau_social icon-edit-2" reseau_social_liste_id="{{ $reseau_social->liste->id }}" cle="{{ $reseau_social->cle }}" title="modifier"></a></td>
									</tr>
							@endforeach
					</tbody>
			</table>
	</div>

</div>

@endsection

<script>
liste_reseau_social_liste_id = {};
possible_supprimer = false;
var el_bouton_formulaire;
var el_reseau_social;
var el_pre_url;
var el_cle;

window.onload = init;

function init() {
  el_bouton_formulaire = document.querySelector("form button")
  el_reseau_social = document.getElementById("reseaux_sociaux_liste")
  el_pre_url = document.querySelector(".pre_url")
  el_cle = document.getElementById("cle")

  el_reseau_social.addEventListener("change", function(){
      texte_pre_url = this.options[this.selectedIndex].getAttribute('pre_url');
  		if (texte_pre_url=='') {
  			el_pre_url.style.display = "none";
  		} else {
  			el_pre_url.style.display = "inline";
  			el_pre_url.innerText = this.options[this.selectedIndex].getAttribute('pre_url');
  		}
      reseau_social_liste_id = this.options[this.selectedIndex].value;

      if(reseau_social_liste_id in liste_reseau_social_liste_id){
          el_bouton_formulaire.innerText = "Modifier"
          el_bouton_formulaire.setAttribute("texte_bouton", "Modifier")
          el_cle.value = liste_reseau_social_liste_id[reseau_social_liste_id]
          possible_supprimer = true
      } else {
          el_bouton_formulaire.innerText = "Ajouter"
          el_bouton_formulaire.setAttribute("texte_bouton", "Ajouter")
          el_cle.value = ""
          possible_supprimer = false
      }
  })

  el_cle.addEventListener("keyup", function(){
      if(possible_supprimer){
          if(this.value == ""){
              el_bouton_formulaire.innerText = "Supprimer"
          } else {
              el_bouton_formulaire.innerText = el_bouton_formulaire.getAttribute("texte_bouton")
          }
      }
  })

  document.querySelectorAll(".modifier_reseau_social").forEach(element => {

      element.addEventListener("click", function(){
          cle = this.getAttribute("cle")
          reseau_social_id = this.getAttribute("reseau_social_liste_id")

          el_cle.value = cle
          el_reseau_social.querySelector('[value="'+reseau_social_id+'"]').selected = true
          el_reseau_social.dispatchEvent(new Event('change'));
      })

      cle = element.getAttribute("cle")
      reseau_social_liste_id = element.getAttribute("reseau_social_liste_id")
      liste_reseau_social_liste_id[reseau_social_liste_id] = cle
  });
};
</script>
