@extends('layouts.app')

@section('titre', 'Réseaux Sociaux')

@pushonce('styles')
<link rel="stylesheet" type="text/css" href="{{ mix('/css/entite/index_gestion.css') }}">
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestion des réseaux sociaux</h1>

        <div class="section-content">
            <h2>Ajouter un réseau social :</h2>
            <div id="warning">
                <p>Vous ne pouvez avoir qu'un seul réseau social de chaque type.</p>
                <p>Pour supprimer un réseau social, laissez le lien vide, et appuyez sur <i>Supprimer</i></p>
            </div>
            <form method="POST">
                @csrf
                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Réseau social :</p>
                        <select name="reseaux_sociaux_liste_id" id="reseaux_sociaux_liste" class="input" spellcheck="false" required select="{{old('reseaux_sociaux_liste_id') ?? ''}}">
                            <option selected disabled></option>
                            @foreach ($reseaux_sociaux_existants as $reseau_social)
                                <option value="{{ $reseau_social->id }}" pre_url="{{ $reseau_social->pre_url }}">{{ $reseau_social->nom }}</option>
                            @endforeach
                        </select>
                    </label>
    
                    <label class="input_groupe">
                        <p class="titre">* Lien :</p>
                        <div style="display:flex; align-items:center;">
                            <span class="pre_url"></span>
                            <input type="text" name="cle" id="cle" class="input" value="{{old('cle') ?? ''}}"/>
                        </div>
                    </label>
                    <div style="display:flex;justify-content: flex-end;margin-top:10px;">
                        <button type="submit" class="bouton primaire">AJOUTER</span></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="section-content">
            <h2>Réseaux actuels:</h2>
            
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
                                <td class="lien"><a class="couleur" href="{{$reseau_social->liste->pre_url.$reseau_social->cle}}">{{$reseau_social->liste->pre_url.$reseau_social->cle}}</a></td>
                                <td><a class="modifier_reseau_social icon-edit-2" reseau_social_liste_id="{{ $reseau_social->liste->id }}" cle="{{ $reseau_social->cle }}" title="modifier"></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
	</section>
</main>


<script>
    
liste_reseau_social_liste_id = {}
possible_supprimer = false

el_bouton_formulaire = document.querySelector("form button")
el_reseau_social = document.getElementById("reseaux_sociaux_liste")
el_pre_url = document.querySelector(".pre_url")
el_cle = document.getElementById("cle")

el_reseau_social.addEventListener("change", function(){
    el_pre_url.innerText = this.options[this.selectedIndex].getAttribute('pre_url');
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
</script>
@endsection
