@extends('layouts.app-without-sidebar')

@section('titre', 'Calendrier')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/evenements/calendrier.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/documentation-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/switch-campus.css') }}" type="text/css" />
@endpushonce

@section('content')


    <head>
        <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    </head>

    <main id="main-content">
        <x-calendrier-switch-campus :campus="$site"></x-calendrier-switch-campus>

        @if (Auth::check())
            <div id="boutons">
                <p id="retour" class="bouton secondaire ombre_petite" style="width:100px;">
                    < Accueil</p>
                        <p id="fleche-gauche" class="icon-container"> <i class="fa-solid fa-arrow-left fa-xl"></i> </p>
                        <h1 id="date" style="text-align:center;"></h1>
                        <p id="fleche-droite" class="icon-container"> <i class="fa-solid fa-arrow-right fa-xl"></i> </p>
            </div>

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


            <div id="info" class="popup">
                <div class="petit">
                    <div class="documentation card">
                        <p class="bouton secondaire ombre_petite info_bouton retour">
                            < Retour</p>

                                <div class="contenu_doc" id="contenu_doc">
                                    <h1 id="titre"></h1>
                                    <p id="organisateur"><em>Organisateur :</em> </p>
                                    <p id="description"><em>Description :</em> </p>
                                    <p id="lieu"><em>Lieu :</em> </p>
                                    <p id="heure_debut"><em>Heure de début :</em> </p>
                                    <p id="heure_fin"><em>Heure de fin :</em> </p>
                                </div>

                                <div id="gerer" style="display:flex;">
                                </div>
                    </div>
                </div>
            </div>
        @else
            <p class="should-be-connected no-content">Vous devez être connecté pour consulter le calendrier</p>
        @endif
    </main>

    <script>
        events = {!! json_encode($events) !!}
        evenements_prives = {!! json_encode($evenements_prives) !!}
        site = {!! json_encode($site) !!}

        el_calendrier = document.getElementById("calendrier");

        function creation_calendrier(index_jour_debut, nbr_jours_dans_mois) {
            jours = ["Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam.", "Dim."]

            // remplissage
            if (responsive.matches) { // max-width: 768px (for phone)
                for (var i = 1; i <= nbr_jours_dans_mois; i++) {
                    //condition pour colorier la date d aujourd hui sur le calendrier
                    if (mois_courant && i == jour_actuel) {
                        el_calendrier.innerHTML += (
                            "<div class='jour' id='today'><div style='margin-left:10px; flex:1 1 auto;'>" + jours[(
                                index_jour_debut + i - 1) % 7] + "<br>" + i + "</div><div class='num_jour' num_jour='" +
                            i + "''></div></div>");
                        document.getElementById("today").style.cssText =
                            'border: 1px solid var(--couleur_accentuation); box-shadow: 0 0 7px; background-color:rgba(127,127,127,0.30)';
                    } else {
                        el_calendrier.innerHTML += ("<div class='jour'><div style='margin-left:10px; flex:1 1 auto;'>" +
                            jours[(index_jour_debut + i - 1) % 7] + "<br>" + i +
                            "</div><div class='num_jour' num_jour='" + i + "''></div></div>");

                    }
                }
            } else {
                // column headings
                for (var i = 0; i < jours.length; i++) {
                    el_calendrier.innerHTML += ("<div class='nom_jour'>" + jours[i] + "</div>")
                }

                // remplissage du calendrier avant le début du mois
                for (var i = 1; i <= index_jour_debut; i++) {
                    el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
                }

                for (var i = 1; i <= nbr_jours_dans_mois; i++) {
                    //condition pour colorier la date d aujourd hui sur le calendrier
                    if (mois_courant && i == jour_actuel) {
                        el_calendrier.innerHTML += ("<div class='jour' id='today' num_jour='" + i +
                            "''><div class='num-jour'>" + i +
                            "</div></div>");
                        document.getElementById("today").style.cssText =
                            'border: 1px solid var(--couleur_accentuation); box-shadow: 0 0 7px; background-color:rgba(127,127,127,0.30)';
                    } else {
                        el_calendrier.innerHTML += ("<div class='jour' num_jour='" + i + "''><div class='num-jour'>" + i +
                            "</div></div>");

                    }
                }

                // remplissage du calendrier apres la fin du mois
                for (var i = 0; i < 7 - (nbr_jours_dans_mois + index_jour_debut) % 7; i++) {
                    el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
                }
            }
        }

        var nbr_jours_dans_mois = 0
        var index_jour_debut = 0

        function remplissage(annee, mois) { //mois : 0=>11
            el_calendrier.innerHTML = "";
            nbr_jours_dans_mois = new Date(annee, mois + 1, 0).getDate();
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
            } else {
                mois_courant = false;
            }
        }

        // Redirection bouton retour
        document.getElementById("retour").onclick = function() {
            location.href = "/";
        };

        entite = {!! json_encode($entite) !!}
        //place les events dans le calendrier
        function event_dans_calendrier(evenements, mois, annee) {
            const range = (start, end, length = end - start + 1) => Array.from({
                length
            }, (_, i) => start + i)

            for (var i = 0; i < evenements.length; i++) {
                date_temps_debut = new Date(evenements[i]["temps_debut"])
                date_temps_fin = new Date(evenements[i]["temps_fin"])

                jour_debut = date_temps_debut.getDate()
                jour_fin = date_temps_fin.getDate()
                //détermine l'heure du jour de fin
                heure_jour_fin = date_temps_fin.getHours()

                id_mois_affiche = mois + annee * 12
                if (id_mois(date_temps_debut) < id_mois_affiche) {
                    tableau = range(1, jour_fin)
                    if (heure_jour_fin < 8) {
                        tableau.pop()
                    }
                } else if (id_mois(date_temps_fin) > id_mois_affiche) {
                    tableau = range(jour_debut, nbr_jours_dans_mois)
                } else if (jour_debut < jour_fin) {
                    tableau = range(jour_debut, jour_fin)
                    if (heure_jour_fin < 8) {
                        tableau.pop()
                    }
                } else {
                    tableau = [jour_debut]
                }

                for (var j = 0; j < tableau.length; j++) {
                    placer_evenement_dans_jour(tableau[j], i, evenements);
                }
            }
        }

        function id_mois(date) {
            return date.getMonth() + date.getFullYear() * 12
        }

        function placer_evenement_dans_jour(jour, index_evenement, evenements) {
            el_jour = document.querySelector('[num_jour="' + jour + '"]');
            if (evenements[index_evenement]["validation"] == 0) {
                el_jour.innerHTML += "<div id=" + evenements[index_evenement]["slug"] + " class='evenement non_valide' >" +
                    evenements[index_evenement]["titre"] + "</div>"
            } else {
                el_jour.innerHTML += "<div id=" + evenements[index_evenement]["slug"] +
                    " class='evenement' style='background-color:" + evenements[index_evenement]["couleur_claire"] + "'>" +
                    evenements[index_evenement]["titre"] + "</div>"
            }
        }

        event_dans_calendrier(events, mois, annee);
        event_dans_calendrier(evenements_prives, mois, annee);


        // GERER CHANGEMENT MOIS
        document.getElementById("fleche-gauche").addEventListener("click", function() {
            mois -= 1;
            test_mois_courant()
            remplissage(annee, mois);
            event_choix_calendrier();
        })

        document.getElementById("fleche-droite").addEventListener("click", function() {
            mois += 1;
            test_mois_courant()
            remplissage(annee, mois);

            event_choix_calendrier();
        })

        function event_choix_calendrier() {
            if (entite === "") {
                jQuery.ajax({
                    type: "GET",
                    url: "/calendrier/index_mois_json_general/" + annee + "-" + mois + '/' + site,
                    success: (data) => {
                        result_mois = mois % 12;
                        afficher_mois_annee(result_mois);

                        event_dans_calendrier(data.events, mois, annee);
                        event_dans_calendrier(data.evenements_prives, mois, annee);

                        listener_events(data.events);
                        listener_events(data.evenements_prives);
                    },
                    error: function() {
                        console.log(arguments);
                    }
                });
            } else {
                jQuery.ajax({
                    type: "GET",
                    url: "calendrier/index_mois_json/" + annee + "-" + mois,
                    success: (data) => {
                        result_mois = mois % 12;
                        afficher_mois_annee(result_mois);

                        event_dans_calendrier(data.events, mois, annee);
                        event_dans_calendrier(data.evenements_prives, mois, annee);

                        listener_events(data.events);
                        listener_events(data.evenements_prives);
                    },
                    error: function() {
                        console.log(arguments);
                    }
                });
            }
        }





        result_mois = mois % 12;
        annee_choisie = annee;
        afficher_mois_annee(result_mois);

        function afficher_mois_annee(result_mois) {
            while (result_mois < 0) {
                result_mois += 12;
            }

            calcul_annee = Math.trunc(mois / 12);
            if (mois / 12 < 0 && Math.trunc(mois / 12) != mois / 12) {
                annee_choisie = annee + calcul_annee - 1;
            } else if (mois / 12 < 0 && Math.trunc(mois / 12) == mois / 12) {
                annee_choisie = annee + calcul_annee;
            } else {
                annee_choisie = annee + calcul_annee;
            }

            changer_mois = document.getElementById("date");
            switch (result_mois) {
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
                listener_click_evenement.addEventListener("click", function() {
                    for (var i = 0; i < evenement.length; i++) {
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
            listener_click_retour.addEventListener("click", function() {
                refresh();

                document.getElementById("info").classList.remove("visible");
            });
        });



        var el_wrapper = document.getElementById("wrapper");

        function afficher_informations_supplementaires(index_evenement, evenements) {
            refresh();

            document.getElementById("gerer").innerHTML +=
                `<a href="/${evenements[index_evenement]['uid']}/entite/evenement/${evenements[index_evenement]['slug']}" class="secondaire bouton bouton_action ombre_petite" style="margin:15px; color:black; border-color:black;">Détails</a>`;

            document.getElementById("titre").innerHTML += evenements[index_evenement]["titre"];
            document.getElementById("organisateur").innerHTML += evenements[index_evenement]["nom"];
            document.getElementById("description").innerHTML += evenements[index_evenement]["description"];
            document.getElementById("lieu").innerHTML += evenements[index_evenement]["lieu"];
            document.getElementById("heure_debut").innerHTML += evenements[index_evenement]["temps_debut"].substring(10,
                16);
            document.getElementById("heure_fin").innerHTML += evenements[index_evenement]["temps_fin"].substring(10, 16);

            document.getElementById("info").classList.add("visible");
        }

        function refresh() {
            document.getElementById("gerer").innerHTML = "";

            document.getElementById("titre").innerHTML = '';
            document.getElementById("organisateur").innerHTML = '<em>Organisateur :</em> ';
            document.getElementById("description").innerHTML = '<em>Description :</em> ';
            document.getElementById("lieu").innerHTML = '<em>Lieu :</em> ';
            document.getElementById("heure_debut").innerHTML = '<em>Heure de début :</em> ';
            document.getElementById("heure_fin").innerHTML = '<em>Heure de fin :</em> ';
        }
    </script>


@endsection
