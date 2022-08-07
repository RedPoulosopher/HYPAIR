@extends('layouts.app')

@section('titre', 'Évènement')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<style>
.bouton_action {
	min-width: 0;
    max-width: 80px;
    font-size: 0.8em;
    padding: 5px;
    margin: 2px 0 2px 10px;
    text-align: start;
}
table {
    border-spacing: 5px 25px;
}
.popup {
    display: none;
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
#info {
    position: absolute;
    top: 450px;
}
</style>

<div id="wrapper">
    <div id="contenu" class="petit">
        <h1>- Évènements -</h1>
        @if(Session::has('success'))
        <p class="explication">Bienvenue sur la page concernant les évènements !</p>
        @endif
        <div>
            @csrf
            @if ($errors->any())
            <div class="erreurs">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            

            @if($gerer_evenement)
		    <div style="margin:70px 0px;" class="centre-element">            		
			    <a href="evenement/formulaire" class="bouton tertiaire ombre_petite administrateur">
                    <span>Créer un évènement</span>
                </a>
            </div>
            @endif
		
            @if (count($tables) != 0)
            <div class="groupe ombre_petite">
                <h2>Liste des évènements</h2>
                <table style="text-align: center;">
                    <tr>
                        <th>Titre</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Lieu</th><!--
                        <th>Nombre de participants max</th>
                        <th>Pour cotisants ?</th>-->
                        <th>Confidentialité</th>
                        <th>Statut</th>
                    </tr> 
                                     
                    @foreach ($tables as $table)
                    <tr>
                        <td><?= $table['titre'] ?></td>
                        <td><?= $table['temps_debut'] ?></td>
                        <td><?= $table['temps_fin'] ?></td>
                        <td><?= $table['lieu'] ?></td><!--
                        <td><?= $table['max_participation'] ?></td>
                        
                        @if ($table['pour_cotisant'] == 0)                          
                        <td>Oui</td>                        
                        @else if ($table['pour_cotisant'] == 1)
                        <td>Non</td>
                        @endif-->

                        @if ($table['confidentialite'] == 0)                          
                        <td>Public</td>
                        @elseif ($table['confidentialite'] == 1)
                        <td>Membres de l'assos</td>
                        @elseif ($table['confidentialite'] == 2)
                        <td>Responsables & bureau</td>
                        @elseif ($table['confidentialite'] == 3)
                        <td>Bureau</td>
                        @elseif ($table['confidentialite'] == 4)
                        <td>Prez & vice-prez</td>
                        @endif

                        @if($table['confidentialite'] == 0)
                            @if ($table['validation'] == 1)                          
                            <td>Validé</td>
                            @elseif ($table['validation'] == 0)
                            <td>En attente de validation</td>
                            @endif
                        @else
                            <td>/</td>
                        @endif

                        <td>
                            <a href="evenement/<?= $table['slug'] ?>" class="secondaire bouton bouton_action ombre_petite administrateur" style="color:black; border-color:black;">Détail</a>
                            @if($gerer_evenement)
                            <p class="suppression_entite secondaire bouton bouton_action ombre_petite administrateur">Supprimer</p>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </table>
            </div>
            @else
            <h4>Il n'y a aucun évènement prévu !</h4>
            @endif


        @if($entite == 'bde' && in_array(13, $entite_user) && $gerer_evenement == 1)
        <div class="groupe ombre_petite">
            <h2>Liste des évènements en attente de validation</h2>

            @if (count($tables_attente_validation) != 0)
            <table style="text-align: center;">
                    <tr>
                        <th>Entités</th>
                        <th>Titre</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Lieu</th>
                    </tr> 
                                     
                    @foreach ($tables_attente_validation as $table)                    
                    @if ($table['validation'] == 0)
                    <tr>
                        <td><?= $table['nom'] ?></td>
                        <td><?= $table['titre'] ?></td>
                        <td><?= $table['temps_debut'] ?></td>
                        <td><?= $table['temps_fin'] ?></td>
                        <td><?= $table['lieu'] ?></td>
                       
                        <td>
                            <a href="/<?= $table['uid'] ?>/entite/evenement/<?= $table['slug'] ?>" class="secondaire bouton bouton_action ombre_petite administrateur" style="color:black; border-color:black;">Detail</a><form method="POST" action="/bde/entite/evenement/validation">
                                @csrf
                                <button type="submit" name="id" value="<?= $table['id'] ?>" class="secondaire bouton bouton_action ombre_petite administrateur" style="color:green; border-color:green;">Valider</button>
                            </form>
                            <p class="suppression_bde secondaire bouton bouton_action ombre_petite administrateur">Supprimer</p>  
                        </td>

                    </tr>
                    @endif
                    @endforeach
            </table>
            @else
            <h4>Il n'y a aucun évènement en attente de validation !</h4>
            @endif
        </div>      
    </div>
    @endif

    
    <div id="info" class="popup">
            <div class="documentation ombre_petite" >
                <div class="contenu_doc" id="contenu_doc">
                    <h2>Attention !</h2>
                    <p id="message">Vous êtes sur le point de supprimer un évènement. </p>
                    <p style='font-style:italic;'>Cette action est irréversible.</p>
                </div>

                <div style="display:flex;">
                    <div id="gerer"></div>
                    <p class="bouton secondaire info_bouton ombre_petite" style="margin:15px;">Annuler</p>
                </diV>

            </div>
        </div>
</div>


<script>

events = {!!json_encode($tables)!!}

const listener_click_retour = document.querySelectorAll('.info_bouton');

listener_click_retour.forEach((listener_click_retour, index) => {
    listener_click_retour.addEventListener("click", function(){
        refresh();

        document.getElementById("info").classList.add("popup");
    });
});


listener_events(events);

function listener_events(evenements) {
    const listener_click_evenements = document.querySelectorAll('.suppression_entite');
    listener_click_evenements.forEach((listener_click_evenement, index) => {
        listener_click_evenement.addEventListener("click", function(){
            afficher_informations_supplementaires(index, evenements);
        });
    });
}


// Partie BDE
events_attente = {!!json_encode($tables_attente_validation)!!}
listener_events_bde(events_attente);

function listener_events_bde(evenements) {
    const listener_click_evenements = document.querySelectorAll('.suppression_bde');
    listener_click_evenements.forEach((listener_click_evenement, index) => {
        listener_click_evenement.addEventListener("click", function(){
            afficher_informations_supplementaires(index, events_attente);
        });
    });
}

function afficher_informations_supplementaires(index_evenement, evenements) {    
    refresh();
    //document.getElementById('info').style.top = event.clientX + "px";
        document.getElementById("gerer").innerHTML += `
            <form method="POST" action="evenement/suppression">
                @csrf
                @if ($gerer_evenement)
                    <button type="submit" name="id" value=`+ evenements[index_evenement]['id'] + ` class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
                @endif
            </form>`;
    document.getElementById("message").innerText += " Voulez-vous vraiment supprimer : « " + evenements[index_evenement]["titre"] + " » ?";

    document.getElementById("info").classList.remove("popup"); 
}

// Fin partie BDE

function refresh() {
    document.getElementById("message").innerText = 'Vous êtes sur le point de supprimer un évènement.';
    document.getElementById("gerer").innerHTML = "";
}


</script>

@endsection