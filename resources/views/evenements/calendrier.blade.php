@extends('layouts.app')

@section('titre', 'Evènement')

@section('content')

<style>
html {
    font-family: system-ui;
}
#calendrier {
    /* display:flex;
    flex-wrap: wrap;
    width:100%; */
    padding: 10px var(--side-padding);
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}
#calendrier .nom_jour {
    text-align: center;
    font-weight: 500;
    padding-bottom: 7px;
    border-bottom: 1px solid rgba(166, 168, 179, 0.12);
}
#calendrier .jour{
    /* width: calc(100% * 1/7); */
    padding:2px;
    min-height: 100px;
    box-sizing: border-box;
    --border: 1px solid rgba(166, 168, 179, 0.12);
    border-bottom: var(--border);
    border-right: var(--border);
}
#calendrier .jour:nth-child(7n+1) {
border-left: var(--border);
}

#calendrier .jour.desactive{
    background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='rgba(127,127,127,0.15)' fill-opacity='1' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
    cursor: not-allowed;
}
</style>


<div id="wrapper">
    <div id="contenu" class="grand">
        {{-- <select>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        <select>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select> --}}
        <div id="calendrier">
        </div>
    </div>
</div>

<script>

events = {!!json_encode($events)!!}

el_calendrier = document.getElementById("calendrier");

function creation_calendrier(index_jour_debut, nbr_jours_dans_mois) {
    // column headings
    jours = ["lun","mar","mer","jeu","ven","sam","dim"]
    for(var i = 0; i < jours.length; i++){
        el_calendrier.innerHTML += ("<div class='nom_jour'>" + jours[i] + "</div>")
    }

    // remplissage du calendrier avant le début du mois
    for (var i = 1; i <= index_jour_debut; i++) {
        el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
    }

    // remplissage
    for(var i=1; i<=nbr_jours_dans_mois; i++) {
        el_calendrier.innerHTML += ("<div class='jour' num_jour='" + i + "''><div>" + i + "</div></div>")
    }

    console.log(nbr_jours_dans_mois)
    console.log(index_jour_debut)
    // remplissage du calendrier apres la fin du mois
    for (var i = 0; i < 7 - (nbr_jours_dans_mois+index_jour_debut)%7; i++) {
        el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
    }
}

var nbr_jours_dans_mois = 0
var index_jour_debut = 0
function remplissage(annee, mois){ //mois : 0=>11
    el_calendrier.innerHTML=""
    nbr_jours_dans_mois = new Date(annee, mois+1, 0).getDate();
    index_jour_debut = new Date(annee, mois, 1).getUTCDay();

    creation_calendrier(index_jour_debut, nbr_jours_dans_mois)
}

//genere le calendrier du mois courant
let aujourdhui = new Date();
let mois = aujourdhui.getMonth();
let annee = aujourdhui.getFullYear();
remplissage(annee, mois)

//place les events dans le calendrier
function event_dans_calendrier(evenements, mois, annee){
    const range = (start, end, length = end - start + 1) => Array.from({ length }, (_, i) => start + i)

    for(var i=0; i < evenements.length ; i++){
        date_temps_debut = new Date (evenements[i]["temps_debut"])
        date_temps_fin = new Date (evenements[i]["temps_fin"])

        jour_debut = date_temps_debut.getDate()
        jour_fin = date_temps_fin.getDate()
        //détermine l'heure du jour de fin
        heure_jour_fin = date_temps_fin.getHours()

        id_mois_affiche = mois+annee*12
        if(id_mois(date_temps_debut)<id_mois_affiche){
            tableau = range(1, jour_fin)
            if (heure_jour_fin < 8){
                tableau.pop()
            }
        } else if (id_mois(date_temps_fin)>id_mois_affiche){
            tableau = range(jour_debut, nbr_jours_dans_mois)
        } else if (jour_debut < jour_fin) {
            tableau = range(jour_debut, jour_fin)
            if (heure_jour_fin < 8){
                tableau.pop()
            }
        } else {
            tableau = [jour_debut]
        }
        //on parcours le tableau qu'on vient de creer, on appelle placer_evenement_dans_jour a chaque fois
        for (var j=0 ; j<tableau.length ; j++){
            placer_evenement_dans_jour(tableau[j], i, evenements)
        }
    }
}
function id_mois(date){
    return date.getMonth()+date.getFullYear()*12
}
function placer_evenement_dans_jour(jour, index_evenement, evenements){
    el_jour = document.querySelector('[num_jour="' + jour + '"]')
    el_jour.innerHTML += "<div style='background-color:"+evenements[index_evenement]["couleur_claire"]+"'>" + evenements[index_evenement]["titre"] + "</div>"
}

event_dans_calendrier(events, mois, annee)

//a faire : requete asynchrone pour recup les events du mois demande par l utilisateur. la requete est generee quand l utilisateur demande un mois particulier
//a faire : reconstruire le calendrier du bon mois et de la bonne année
//pour simuler une demande de l utilisateur, appeler la requqte asynchrone avec un mois et une annee random

//un listener click pour chaque evenement du calendrier, qui affiche un ecnadre avec les infos complementaires

</script>


@endsection