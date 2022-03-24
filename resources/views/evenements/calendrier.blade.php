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
        el_calendrier.innerHTML += ("<div class='jour' num_jour='" + i + "''>" + i + "</div>")
    }

    // remplissage du calendrier apres la fin du mois
    for (var i = 1; i < (nbr_jours_dans_mois+index_jour_debut)%7; i++) {
        el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
    }
}

var nbr_jours_dans_mois = 0
var index_jour_debut = 0
function remplissage(){
    let aujourdhui = new Date();
    let mois = aujourdhui.getMonth();
    let annee = aujourdhui.getFullYear();
    nbr_jours_dans_mois = new Date(annee, mois+1, 0).getDate();

    index_jour_debut = new Date(annee, mois, 1).getUTCDay();
}

remplissage()
creation_calendrier(index_jour_debut, nbr_jours_dans_mois)
</script>


@endsection