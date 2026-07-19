@extends('layouts.app-without-sidebar')

@section('titre', 'Calendrier')

@pushonce('styles')
    @vite([
        'resources/css/evenements/calendrier.scss',
        'resources/css/documentation-popup.scss',
        'resources/css/components/switch-campus.scss',
    ])
@endpushonce

@pushonce('start-scripts')
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
@endpushonce

@section('content')

    <main id="main-content">
        @if (Auth::check())
            <x-switch-campus :campus="$site"></x-switch-campus>

            <div id="boutons">
                <p id="fleche-gauche" class="icon-container"> <i class="fa-solid fa-arrow-left fa-xl"></i> </p>
                <h1 id="date" style="text-align:center;"></h1>
                <p id="fleche-droite" class="icon-container"> <i class="fa-solid fa-arrow-right fa-xl"></i> </p>
            </div>

            <div id="calendrier">
            </div>

            <div id="info" class="popup">
                <div class="petit">
                    <div class="documentation card">
                        <span id="retour" class='info_bouton' tabindex="0">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </span>

                        <div class="contenu_doc" id="contenu_doc">
                            <h1 id="titre"></h1>
                            <p id="tags"><em>Tags :</em></p>
                            <p id="organisateur"><em>Organisateur :</em> </p>
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
        events = []
        evenements_prives = []
        site = {!! json_encode($site?->id, JSON_UNESCAPED_UNICODE) !!}
        entite = {!! isset($entite) ? json_encode($entite) : json_encode([]) !!}


        
        el_calendrier = document.getElementById("calendrier");

        const jours = ["Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam.", "Dim."]

        var nbr_jours_dans_mois = 0
        var index_jour_debut = 0

        //remplissage du calendrier selon la taille de la fenetre
        var responsive = window.matchMedia("(max-width: 768px)")
        responsive.addListener(appel)


        //genere le calendrier du mois courant
        let aujourdhui = new Date();
        let mois = aujourdhui.getMonth();
        let annee = aujourdhui.getFullYear();
        //garder une trace de la date actuelle
        let jour_actuel = aujourdhui.getDate();
        let mois_actuel = mois;
        let annee_actuelle = annee;
        mois_courant = true;
        
        appel();


        function creation_calendrier(index_jour_debut, nbr_jours_dans_mois) {

            // remplissage
            if (responsive.matches) { // max-width: 768px (for phone)
                for (var i = 1; i <= nbr_jours_dans_mois; i++) {
                    //condition pour colorier la date d aujourd hui sur le calendrier
                    if (mois_courant && i == jour_actuel) {
                        el_calendrier.innerHTML += (
                            "<div class='jour card' id='today'><div style='margin-left:10px; flex:1 1 auto;'>" + jours[(
                                index_jour_debut + i - 1) % 7] + "<br>" + i + "</div><div class='num_jour' num_jour='" +
                            i + "''></div></div>");
                        document.getElementById("today").style.cssText =
                            'border: 1px solid var(--couleur_accentuation); box-shadow: 0 0 7px; background-color:rgba(127,127,127,0.30)';
                    } else {
                        el_calendrier.innerHTML += (
                            "<div class='jour card'><div style='margin-left:10px; flex:1 1 auto;'>" +
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
                console.log(nbr_jours_dans_mois + " " + index_jour_debut);
                for (var i = 0; i < (70 - (nbr_jours_dans_mois + index_jour_debut)) % 7; i++) {
                    el_calendrier.innerHTML += ("<div class='jour desactive'></div>");
                }
            }
        }


        function capitalizeFirstLetter(val) {
            return String(val).charAt(0).toUpperCase() + String(val).slice(1);
        }

        
        function appel() {
            if (mois == mois_actuel && annee == annee_actuelle) {
                mois_courant = true;
            } else {
                mois_courant = false;
            }
            el_calendrier.innerHTML = "";
            nbr_jours_dans_mois = new Date(annee, mois + 1, 0).getDate();

            // Fix: fonctionne même à l'étranger
            texte_jour_debut = capitalizeFirstLetter(new Date(Date.UTC(annee,mois,1)).toLocaleString('fr',{weekday: 'short', timeZone: 'UTC'}))
            index_jour_debut = jours.findIndex(e => e == texte_jour_debut); //0:Lundi -> 6:Dimanche

            creation_calendrier(index_jour_debut, nbr_jours_dans_mois);

            var pas_entite = !entite || (Array.isArray(entite) && entite.length === 0) || entite === "";


            url = "/calendrier/index_mois_json_general/" + annee + "-" + (mois+1)
            if (site) {
                url = "/calendrier/index_mois_json_general/" + annee + "-" + (mois+1) + '/' + site
            }else if (!pas_entite) {
                url = "/calendrier/index_mois_json_general/" + annee + "-" + (mois+1) + '/' + entite
            }

            jQuery.ajax({
                type: "GET",
                url: url,
                success: (data) => {
                    result_mois = mois % 12;
                    afficher_mois_annee(result_mois);

                    event_dans_calendrier(data.events, mois, annee);
                    event_dans_calendrier(data.evenements_prives, mois, annee);
                },
                error: function() {
                    console.log(arguments);
                }
            });
            
            if (mois_courant) {
                scrollToToday();
            } else {
                scrollToTop();
            }
        }

        function scrollToToday() {
            const y = document.getElementById("today").getBoundingClientRect().top - el_calendrier.getBoundingClientRect()
                .top - 15;
            el_calendrier.scroll({
                top: y,
                behavior: 'smooth'
            });
        }

        function scrollToTop() {
            el_calendrier.scroll({
                top: 0,
                behavior: 'smooth'
            });
        }



        //place les events dans le calendrier
        function event_dans_calendrier(evenements, mois, annee) {
            const range = (start, end, length = end - start + 1) => Array.from({
                length
            }, (_, i) => start + i)

            for (var i = 0; i < evenements.length; i++) {
                // CHANGÉ : started_at / ended_at au lieu de temps_debut / temps_fin
                date_temps_debut = new Date(evenements[i]["started_at"])
                date_temps_fin = new Date(evenements[i]["ended_at"])

                jour_debut = date_temps_debut.getDate()
                jour_fin = date_temps_fin.getDate()
                //détermine l'heure du jour de fin
                heure_jour_fin = date_temps_fin.getHours()

                id_mois_affiche = mois + annee * 12
                //Si l'évènement commence avant le début du mois et finit après la fin du mois affiché, on l'affiche sur tout le mois
                if (id_mois(date_temps_debut) < id_mois_affiche && id_mois(date_temps_fin) > id_mois_affiche) {
                    tableau = range(1, nbr_jours_dans_mois)
                } else if (id_mois(date_temps_debut) < id_mois_affiche) {//Si l'èvènement commence avant le début du mois affiché, on l'affiche à partir du 1
                    tableau = range(1, jour_fin)
                    if (heure_jour_fin < 8) {
                        tableau.pop()
                    }
                } else if (id_mois(date_temps_fin) > id_mois_affiche) {//Si l'évènement termine après la fin du mois affiché, on l'affiche jusqu'à la fin du mois
                    tableau = range(jour_debut, nbr_jours_dans_mois)
                } else if (jour_debut < jour_fin) {//Si l'évènement n'est pas à cheval sur plusieurs mois
                    tableau = range(jour_debut, jour_fin)
                    if (heure_jour_fin < 8) {
                        tableau.pop()
                    }
                } else {
                    tableau = [jour_debut]
                }

                for (var j = 0; j < tableau.length; j++) {
                    placer_evenement_dans_jour(tableau[j], evenements[i]);
                }
            }
            listener_events(evenements);
        }

        function id_mois(date) {
            return date.getMonth() + date.getFullYear() * 12
        }

        function placer_evenement_dans_jour(jour, evenement) {
            let el_jour = document.querySelector('[num_jour="' + jour + '"]');
            if (!el_jour) return; // sécurité si le jour n'existe pas dans le mois affiché

            // CHANGÉ : validation_status (string) au lieu de validation (0/1)
            // ATTENTION : adapte cette condition si "Proposition" n'est pas la seule
            // valeur qui doit apparaître "non_valide" (ex: "Validé", "Refusé", etc.)
            let couleur = evenement["color_1"] || "#8ecae6"; // couleur par défaut si absente

            if (evenement["validation_status"] === "Proposition" || evenement["validation_status"] === "Annulé" || evenement["validation_status"] === "Déclaration déposée") {
                el_jour.innerHTML += "<div id='" + evenement["uid"] + "' class='evenement non_valide'>" +
                    evenement["title"] + "</div>"
            } else {
                el_jour.innerHTML += "<div id='" + evenement["uid"] +
                    "' class='evenement' style='background-color:" + couleur + "'>" +
                    evenement["title"] + "</div>"
            }
        }


        // GERER CHANGEMENT MOIS
        document.getElementById("fleche-gauche").addEventListener("click", function() {
            if(mois > 0){
                mois --;
            }else{//Si on est en janvier, on passe en décembre de l'année précédente
                mois = 11;
                annee--;
            }
            appel()
        })

        document.getElementById("fleche-droite").addEventListener("click", function() {
            if(mois < 11){
                mois++;
            }else{
                mois = 0;//si on est en décembre, on passe en janvier de l'année suivante
                annee++;
            }
            appel()
        })


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


        function listener_events(evenement) {
            const listener_click_evenements = document.querySelectorAll('.evenement');

            listener_click_evenements.forEach((listener_click_evenement, index) => {
                listener_click_evenement.addEventListener("click", function() {
                    for (var i = 0; i < evenement.length; i++) {
                        if (evenement[i]["uid"] == this.id) {
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

            let ev = evenements[index_evenement];

            // CHANGÉ : uid au lieu de uid+slug (route à vérifier selon ton contrôleur)
            document.getElementById("gerer").innerHTML +=
                `<a href="/${ev['entite_uid']}/entite/evenement/${ev['uid']}" class="secondaire bouton bouton_action" style="margin-top:10px; background-color: var(--light-grey); color:var(--couleur_police_primaire); border:none;">Détails</a>`;

            // CHANGÉ : title au lieu de titre
            document.getElementById("titre").innerHTML += ev["title"];

            // ATTENTION : "nom" n'existe pas dans le JSON envoyé - vérifie si
            // l'organisateur vient d'une relation (ex: ev.entite.nom) et adapte ici
            document.getElementById("organisateur").innerHTML += ev["nom"] ?? ev["entite_uid"] ?? "";

            document.getElementById("tags").innerHTML += ev["tags"] ?? "";
            if(ev["lieu"]){
                document.getElementById("lieu").innerHTML += ev["lieu"];
                document.getElementById("lieu").style.display = "block";
            }else{
                document.getElementById("lieu").style.display = "none";
            }

            // CHANGÉ : started_at / ended_at au lieu de temps_debut / temps_fin
            document.getElementById("heure_debut").innerHTML += ev["started_at"].substring(11, 16);
            document.getElementById("heure_fin").innerHTML += ev["ended_at"].substring(11, 16);

            document.getElementById("info").classList.add("visible");
        }

        function refresh() {
            document.getElementById("gerer").innerHTML = "";

            document.getElementById("titre").innerHTML = '';
            document.getElementById("organisateur").innerHTML = '<em>Organisateur :</em> ';
            document.getElementById("tags").innerHTML = '<em>Tags :</em> ';
            document.getElementById("lieu").innerHTML = '<em>Lieu :</em> ';
            document.getElementById("heure_debut").innerHTML = '<em>Heure de début :</em> ';
            document.getElementById("heure_fin").innerHTML = '<em>Heure de fin :</em> ';
        }
    </script>
@endsection
