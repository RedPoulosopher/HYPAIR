@extends('layouts.app-without-sidebar')

@section('titre', 'Calendrier')

@section('content')

<style>
    html {
        font-family: system-ui;
    }
    #calendrier {
        padding: 10px var(--side-padding);
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }
    #calendrier .nom_jour {
        text-align: center;
        font-weight: var(--fw-medium);
        padding-bottom: 7px;
        border-bottom: 1px solid rgba(166, 168, 179, 0.12);
    }
    #calendrier .jour{
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
    .documentation {
        width:100%;
        background:var(--gris_2);
        padding:35px;
        border-radius:25px;
        box-sizing:border-box;
        border:1px solid var(--gris_1);
        box-sizing: ;
    }
    .popup-cachee {
        display: none;
    }
    #wrapper {
        display: flex;
        flex-direction: column;
    }
    #boutons {
        display: flex;
        position: fixed;
        top: 20px;
    }
    #contenu {
        position: fixed;
        top: 100px;
        height: 100%;
    }
    .bouton {
        padding: 10px;
        margin-left: 20px;
        margin-right: 20px;
    }
    .evenement:hover {
    color: white;
    box-shadow: 0 0 15px 2px rgb(127,127,127);
    }
    .evenement {    
        transition: all 0.3s ease-out;
    } 
    .non_valide {
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='rgba(255, 0, 0, 0.55)' fill-opacity='1' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
    
    }
    #retour {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
    }

    @media (max-width: 768px) { /*FAIRE POPUP*/
        #calendrier {
            min-width: 0px;
            grid-template-columns: repeat(1, 1fr);
            overflow: scroll;
            height: 80vh;
            gap: 1.2em;
        }
        #calendrier .jour{
            border: 1px solid black;
            margin: auto 2%;
            border-radius: 15px;
            display: flex;
            flex-direction: row;
        }
        .num_jour {
            flex: 20 1 auto;
            border-radius: 10px;
        }
        .num_jour .evenement{
            border-radius: 10px;
            padding-left: 5px;
            padding-right: 5px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        #calendrier .jour:nth-child(7n+1) {
            border: 1px solid black;
        }
        #retour {
            position: fixed;
            top: 20px;
            left: 20px;
        }
        .bouton {
            min-width: 20px;
            width: 50px;
            min-height: 10px;
            height: 20px;
        }
        #titre {
            font-size: 1.2em;
        }
        #info .retour {
            font-size: 0.8em;        
        }
    }
    @media (max-width: 632px) { 
        #boutons {
            top: 80px;
        }
        #contenu {
            top: 165px;
        }
    }

</style>

<head>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>

<div id="wrapper">
  
    <div id="boutons">
        <p id="retour" class="bouton secondaire ombre_petite" style="width:100px;">< Accueil</p>
        <p id="fleche-gauche" class="bouton secondaire ombre_petite info_bouton"> <--- </p>
        <h2 id="date" style="text-align:center;"></h2>  
        <p id="fleche-droite" class="bouton secondaire ombre_petite info_bouton"> ---> </p>
    </div>

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


    <div id="info" class="popup-cachee" style="position:absolute" >
        <div class="petit" >
            <div class="documentation ombre_petite" >
                <div id="gerer" style="display:flex;">

                 
                </div>

                <div class="contenu_doc" id="contenu_doc">
                    <h1 id="titre"></h1>
                    <h5 id="organisateur">Organisateur : </h5>
                    <p id="description">Description : </p>
                    <p id="lieu">Lieu : </p>
                    <p id="heure_debut">Heure de début : </p>
                    <p id="heure_fin">Heure de fin : </p>
                </div>
                <p class="bouton secondaire ombre_petite info_bouton retour">< Retour</p>
            </div>
        </div>
    </div>
</div>

<script>

    events = {!!json_encode($events)!!}
    evenements_prives = {!!json_encode($evenements_prives)!!}

    el_calendrier = document.getElementById("calendrier");

    function creation_calendrier(index_jour_debut, nbr_jours_dans_mois) {
        jours = ["lun","mar","mer","jeu","ven","sam","dim"]

        // remplissage
        if (responsive.matches) { // max-width: 768px (for phone) 
            for(var i=1; i<=nbr_jours_dans_mois; i++) { 
                //condition pour colorier la date d aujourd hui sur le calendrier
                if (mois_courant && i == jour_actuel) {
                    el_calendrier.innerHTML += ("<div class='jour' id='today'><div style='margin-left:10px; flex:1 1 auto;'>" + jours[(index_jour_debut+i-1)%7] + "<br>" + i + "</div><div class='num_jour' num_jour='" + i + "''></div></div>");
                    document.getElementById("today").style.cssText = 'border: 1px solid var(--couleur_accentuation); box-shadow: 0 0 7px; background-color:rgba(127,127,127,0.30)';
                }
                else {
                    el_calendrier.innerHTML += ("<div class='jour'><div style='margin-left:10px; flex:1 1 auto;'>" + jours[(index_jour_debut+i-1)%7] + "<br>" + i + "</div><div class='num_jour' num_jour='" + i + "''></div></div>");
            
                }
            } 
        } else {
            // column headings
            for(var i = 0; i < jours.length; i++){
                el_calendrier.innerHTML += ("<div class='nom_jour'>" + jours[i] + "</div>")
            }

            // remplissage du calendrier avant le début du mois
            for (var i = 1; i <= index_jour_debut; i++) {
                el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
            }

            for(var i=1; i<=nbr_jours_dans_mois; i++) { 
                //condition pour colorier la date d aujourd hui sur le calendrier
                if (mois_courant && i == jour_actuel) {
                    el_calendrier.innerHTML += ("<div class='jour' id='today' num_jour='" + i + "''><div>" + i + "</div></div>");
                    document.getElementById("today").style.cssText = 'border: 1px solid var(--couleur_accentuation); box-shadow: 0 0 7px; background-color:rgba(127,127,127,0.30)';
                }
                else {
                    el_calendrier.innerHTML += ("<div class='jour' num_jour='" + i + "''><div>" + i + "</div></div>");
                
                }            
            }
            
            // remplissage du calendrier apres la fin du mois
            for (var i = 0; i < 7 - (nbr_jours_dans_mois+index_jour_debut)%7; i++) {
                el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
            }
        }
    }

    var nbr_jours_dans_mois = 0
    var index_jour_debut = 0
    function remplissage(annee, mois){ //mois : 0=>11
        el_calendrier.innerHTML="";
        nbr_jours_dans_mois = new Date(annee, mois+1, 0).getDate();
        index_jour_debut = new Date(annee, mois, 1).getUTCDay();

        creation_calendrier(index_jour_debut, nbr_jours_dans_mois);
    }

    //remplissage du calendrier selon la taille de la fenetre
    var responsive = window.matchMedia("(max-width: 768px)")
    responsive.addListener(appel)
    function appel() {
        remplissage(annee, mois);
        event_choix_calendrier();
    }

    //genere le calendrier du mois courant
    let aujourdhui = new Date();
    let mois = aujourdhui.getMonth();
    let annee = aujourdhui.getFullYear();
    //garder une trace de la date actuelle
    let jour_actuel = aujourdhui.getDate();
    let mois_actuel = mois;
    let annee_actuelle = annee;
    mois_courant = true;
    //remplissage
    test_mois_courant()
    remplissage(annee, mois)
    function test_mois_courant() {    
        if (mois == mois_actuel && annee == annee_actuelle) {
            mois_courant = true;
        }
        else {
            mois_courant = false;        
        }
    }

    // Redirection bouton retour
    document.getElementById("retour").onclick = function () {
        location.href = "/";
    };

    entite = {!!json_encode($entite)!!}
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
        
            for (var j=0 ; j<tableau.length ; j++){
                placer_evenement_dans_jour(tableau[j], i, evenements);
            }
        }
    }
    function id_mois(date){
        return date.getMonth()+date.getFullYear()*12
    }
    function placer_evenement_dans_jour(jour, index_evenement, evenements){
        el_jour = document.querySelector('[num_jour="' + jour + '"]');
        if (evenements[index_evenement]["validation"] == 0) {
            el_jour.innerHTML += "<div id="+evenements[index_evenement]["slug"]+" class='evenement non_valide' >" + evenements[index_evenement]["titre"] + "</div>"
        } else {
            el_jour.innerHTML += "<div id="+evenements[index_evenement]["slug"]+" class='evenement' style='background-color:"+evenements[index_evenement]["couleur_claire"]+"'>" + evenements[index_evenement]["titre"] + "</div>"
        }
    }

    event_dans_calendrier(events, mois, annee);
    event_dans_calendrier(evenements_prives, mois, annee);


    // GERER CHANGEMENT MOIS
    document.getElementById("fleche-gauche").addEventListener("click",  function() {
        mois -= 1;
        test_mois_courant()
        remplissage(annee, mois);
        event_choix_calendrier();
    })

    document.getElementById("fleche-droite").addEventListener("click",  function() {
        mois += 1;
        test_mois_courant()
        remplissage(annee, mois);
        
        event_choix_calendrier();
    })
    if (entite === "") {
        document.getElementById('menu_lateral').style.display = "none";
        document.getElementById('hamburger').style.display = "none";
        document.getElementById('retour').style.display = "block";
        console.log("e");
    }

    function event_choix_calendrier() {
        if (entite === "") {
            jQuery.ajax({
                type: "GET",
                url: "calendrier/index_mois_json_general/"+annee+"-"+mois,
                success: (data) => {
                    result_mois = mois%12;
                    afficher_mois_annee(result_mois);
                    
                    event_dans_calendrier(data.events, mois, annee);
                    event_dans_calendrier(data.evenements_prives, mois, annee);

                    listener_events(data.events);
                    listener_events(data.evenements_prives);
                },
                error: function(){
                    console.log(arguments);
                }
            });
        } else {
            jQuery.ajax({
                type: "GET",
                url: "calendrier/index_mois_json/"+annee+"-"+mois,
                success: (data) => {
                    result_mois = mois%12;
                    afficher_mois_annee(result_mois);
                    
                    event_dans_calendrier(data.events, mois, annee);
                    event_dans_calendrier(data.evenements_prives, mois, annee);

                    listener_events(data.events);
                    listener_events(data.evenements_prives);
                },
                error: function(){
                    console.log(arguments);
                }
            });
        }
    }





    result_mois = mois%12;
    annee_choisie = annee;
    afficher_mois_annee(result_mois);

    function afficher_mois_annee(result_mois) {
        while (result_mois < 0) {
            result_mois += 12;
        }

        calcul_annee = Math.trunc(mois/12);
        if (mois/12 < 0 && Math.trunc(mois/12) != mois/12) {
            annee_choisie = annee + calcul_annee - 1;
        } else if (mois/12 < 0 && Math.trunc(mois/12) == mois/12) { 
            annee_choisie = annee + calcul_annee;
        } else {
            annee_choisie = annee + calcul_annee;
        }

        changer_mois = document.getElementById("date");
        switch(result_mois){
            case 0:
                changer_mois.innerHTML = "Janvier";
                break;
            case 1:
                changer_mois.innerHTML = "Février";
                break;
            case 2:
                changer_mois.innerHTML = "Mars";
                break;
            case 3:
                changer_mois.innerHTML = "Avril";
                break;
            case 4:
                changer_mois.innerHTML = "Mai";
                break;
            case 5:
                changer_mois.innerHTML = "Juin";
                break;
            case 6:
                changer_mois.innerHTML = "Juillet";
                break;
            case 7:
                changer_mois.innerHTML = "Août";
                break;
            case 8:
                changer_mois.innerHTML = "Septembre";
                break;
            case 9:
                changer_mois.innerHTML = "Octobre";
                break;
            case 10:
                changer_mois.innerHTML = "Novembre";
                break;
            case 11:
                changer_mois.innerHTML = "Décembre";
                break;
        }    
        changer_mois.innerHTML += " " + annee_choisie;
    }


    // POP UP
    listener_events(events);
    listener_events(evenements_prives);

    function listener_events(evenement) {
        const listener_click_evenements = document.querySelectorAll('.evenement');

        listener_click_evenements.forEach((listener_click_evenement, index) => {
            listener_click_evenement.addEventListener("click", function(){
                for (var i = 0 ; i < evenement.length ; i++) {
                    if (evenement[i]["slug"] == this.id) {
                        afficher_informations_supplementaires(i, evenement);
                        break;
                    }
                }
            });
        });
    }


    const listener_click_retour = document.querySelectorAll('.info_bouton');

    listener_click_retour.forEach((listener_click_retour, index) => {
        listener_click_retour.addEventListener("click", function(){
            refresh();

            document.getElementById("info").classList.add("popup-cachee");
        });
    });



    var el_wrapper = document.getElementById("wrapper");

    function afficher_informations_supplementaires(index_evenement, evenements) {    
        refresh();
        
        document.getElementById("gerer").innerHTML += `
        <a href="/`+ evenements[index_evenement]['uid'] + `/entite/evenement/`+ evenements[index_evenement]['slug'] + ` " class="secondaire bouton bouton_action ombre_petite" style="margin:15px; color:black; border-color:black;">Détail</a>
        <!--                                        
        @if ($gerer_evenement)
            <a href="/evenement/" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
        @endif
        -->`;
            
        if (evenements[index_evenement]['validation'] == 0) {
            document.getElementById("gerer").innerHTML += `
            <form method="POST" action="/bde/calendrier/validation">
                @csrf
                @if ($gerer_evenement && $entite=="bde")
                    <button type="submit" name="id" value=`+ evenements[index_evenement]['id'] + ` class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
                @endif
            </form>`;
        } else if (evenements[index_evenement]['validation'] == 1 && evenements[index_evenement]['confidentialite'] == 0) {
            document.getElementById("gerer").innerHTML += `
            <form method="POST" action="/bde/calendrier/invalidation">
                @csrf
                @if ($gerer_evenement && $entite=="bde")
                    <button type="submit" name="id" value=`+ evenements[index_evenement]['id'] + ` class="bouton ombre_petite administrateur" style="margin:15px;">Invalider</button>
                @endif
            </form>`;
            
        }
        
        document.getElementById("titre").innerText += evenements[index_evenement]["titre"];
        document.getElementById("organisateur").innerText += evenements[index_evenement]["nom"];
        document.getElementById("description").innerText += evenements[index_evenement]["description"];
        document.getElementById("lieu").innerText += evenements[index_evenement]["lieu"];
        document.getElementById("heure_debut").innerText += evenements[index_evenement]["temps_debut"].substring(10, 16);
        document.getElementById("heure_fin").innerText += evenements[index_evenement]["temps_fin"].substring(10, 16);

        document.getElementById("info").classList.remove("popup-cachee"); 
    }

    function refresh() {
        document.getElementById("gerer").innerHTML = "";

        document.getElementById("titre").innerText = '';
        document.getElementById("organisateur").innerText = 'Organisateur : ';
        document.getElementById("description").innerText = 'Description : ';
        document.getElementById("lieu").innerText = 'Lieu : ';
        document.getElementById("heure_debut").innerText = 'Heure de début : ';
        document.getElementById("heure_fin").innerText = 'Heure de fin : ';
    }

</script>


@endsection