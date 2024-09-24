{{--
    Page d'edition du profil utilisateur, peut y changer photo de profil, nom, prenom, pronoms, promo.
    On voit le mail et le pseudo user associé sans pouvoir le changer.
--}}


@extends('layouts.app-without-sidebar')

@section('titre', 'Gérer les réseaux sociaux')

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
        'resources/css/espace_utilisateur/editer_reseaux_profil.scss',
    ])
@endpushonce

@section('content')

<main id="main-content">

    <section>
        <h1><span class="icon-people"></span> Gestion des réseaux sociaux</h1>
        {{-- ancien bouton retour ci-dessous, a enlever lorsde l'ajout des breadcrumbs --}}
        {{-- <a href="/home" class="bouton secondaire">< Retour au profil</a> --}}
        
        <div class="section-content">
            <form method="POST">
                @csrf
                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre"><span style="color:var(--couleur_accentuation);">*</span> Réseau social :</p>
                        <select name="reseaux_sociaux_liste_id" id="reseaux_sociaux_liste" class="input" spellcheck="false" required>
                            <option selected disabled></option>
                            @foreach ($reseaux_sociaux_existants as $reseau_social)
                                <option value="{{ $reseau_social->id }}" placeholder="{{ $reseau_social->placeholder_utilisateur }}">{{ $reseau_social->nom }}</option>
                            @endforeach
                        </select>
                    </label>
    
                    <label class="input_groupe">
                        <p class="titre"><span style="color:var(--couleur_accentuation);">*</span> Lien :</p>
                        <div style="display:flex;gap:10px;align-items:center;">
                            <input type="text" name="lien" id="lien" class="input"/>
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
        </div>

        <div class="section-content">
            <h2>Réseaux actuels :</h2>
            @if(count($reseaux_sociaux) > 0)
                <div class="table card">
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
                                    <td class="lien"><a class="couleur" href="{{$reseau_social->lien}}">{{$reseau_social->lien}}</a></td>
                                    <td><a class="modifier_reseau_social icon-edit-2" reseau_social_liste_id="{{ $reseau_social->liste->id }}" lien="{{ $reseau_social->lien }}" title="modifier"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <p class="no-content">Aucun réseau social pour le moment</p>
            @endif
        </div>
    
    </section>
</main>

@endsection

<script>
liste_reseau_social_liste_id = {};
possible_supprimer = false;
var el_bouton_formulaire;
var el_reseau_social;
var el_lien;

window.onload = init;

function init() {
  el_bouton_formulaire = document.querySelector("form button")
  el_reseau_social = document.getElementById("reseaux_sociaux_liste")
  el_lien = document.getElementById("lien")

  el_reseau_social.addEventListener("change", function(){

      el_lien.placeholder = this.options[this.selectedIndex].getAttribute('placeholder');
      reseau_social_liste_id = this.options[this.selectedIndex].value;

      if(reseau_social_liste_id in liste_reseau_social_liste_id){
          el_bouton_formulaire.innerText = "Modifier"
          el_bouton_formulaire.setAttribute("texte_bouton", "Modifier")
          el_lien.value = liste_reseau_social_liste_id[reseau_social_liste_id]
          possible_supprimer = true
      } else {
          el_bouton_formulaire.innerText = "Ajouter"
          el_bouton_formulaire.setAttribute("texte_bouton", "Ajouter")
          el_lien.value = ""
          possible_supprimer = false
      }
  })

  el_lien.addEventListener("keyup", function(){
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
          lien = this.getAttribute("lien")
          reseau_social_id = this.getAttribute("reseau_social_liste_id")

          el_lien.value = lien
          el_reseau_social.querySelector('[value="'+reseau_social_id+'"]').selected = true
          el_reseau_social.dispatchEvent(new Event('change'));
      })

      lien = element.getAttribute("lien")
      reseau_social_liste_id = element.getAttribute("reseau_social_liste_id")
      liste_reseau_social_liste_id[reseau_social_liste_id] = lien
  });
};
</script>
