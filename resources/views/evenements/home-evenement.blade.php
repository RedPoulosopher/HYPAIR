@extends('layouts.app-without-sidebar')

@section('titre', 'Évènement')

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
        'resources/css/evenements/home-evenement.scss',
        'resources/css/documentation-popup.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>Évènements</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue sur la page concernant les évènements !</p>
            @endif
            <div class="section-content">
                @csrf
                @if ($errors->any())
                    <div class="erreurs">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif


                <div class="create-btn-container">
                    <a href="evenement/formulaire" class="bouton tertiaire ombre_petite administrateur">
                        <span><i class="fa-solid fa-plus"></i>Créer un évènement</span>
                    </a>
                </div>

                <h2>Liste des évènements :</h2>
                @if (count($evenements) != 0)
                    <div class="table card">
                        <table style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Lieu</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>

                                    {{-- <th>Nombre de participants max</th>
                                    <th>Pour cotisants ?</th>
                                    <th>Confidentialité</th>
                                    <th>Statut</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evenements as $evenement)
                                    <tr>
                                        <td><?= $evenement['titre'] ?></td>
                                        <td><?= $evenement['temps_debut'] ?></td>
                                        <td><?= $evenement['temps_fin'] ?></td>
                                        <td><?= $evenement['lieu'] ?></td>

                                        {{-- <td><?= $evenement['max_participation'] ?></td>
                                        
                                        @if ($evenement['pour_cotisant'] == 0)
                                            <td>Oui</td>
                                        @else
                                            if ($evenement['pour_cotisant'] == 1)
                                                <td>Non</td>
                                        @endif --}}


                                        {{-- @if ($evenement['confidentialite'] == 0)
                                            <td>Public</td>
                                        @elseif ($evenement['confidentialite'] == 1)
                                            <td>Membres de l'assos</td>
                                        @elseif ($evenement['confidentialite'] == 2)
                                            <td>Responsables & bureau</td>
                                        @elseif ($evenement['confidentialite'] == 3)
                                            <td>Bureau</td>
                                        @elseif ($evenement['confidentialite'] == 4)
                                            <td>Prez & vice-prez</td>
                                        @endif --}}


                                        <td>
                                            <a href="evenement/modifier/<?= $evenement['id'] ?>" class="bouton_action"
                                                style="color:black; border-color:black;">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                                <span class="bouton_action warning suppression_event">
                                                    <i class="fa-solid fa-trash fa-lg"></i>
                                                </span>
                                            {{-- </a> --}}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="no-content">Aucun évènement n'est prévu pour le moment</p>
                @endif


                {{-- @if ($entite == 'bde' && in_array(13, $entite_user) && $gerer_evenement == 1)
                    <div class="groupe card">
                        <h2>Liste des évènements en attente de validation</h2>

                        @if (count($evenements_attente_validation) != 0)
                        <table style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Entités</th>
                                        <th>Titre</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Lieu</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    @foreach ($evenements_attente_validation as $evenement)                    
                                    @if ($evenement['validation'] == 0)
                                    <tr>
                                        <td><?= $evenement['nom'] ?></td>
                                        <td><?= $evenement['titre'] ?></td>
                                        <td><?= $evenement['temps_debut'] ?></td>
                                        <td><?= $evenement['temps_fin'] ?></td>
                                        <td><?= $evenement['lieu'] ?></td>
                                    
                                        <td>
                                            <a href="/<?= $evenement['uid'] ?>/entite/evenement/<?= $evenement['slug'] ?>" class="secondaire bouton bouton_action ombre_petite administrateur" style="color:black; border-color:black;">Detail</a><form method="POST" action="/bde/entite/evenement/validation">
                                                @csrf
                                                <button type="submit" name="id" value="<?= $evenement['id'] ?>" class="secondaire bouton bouton_action ombre_petite administrateur" style="color:green; border-color:green;">Valider</button>
                                            </form>
                                            <p class="suppression_bde secondaire bouton bouton_action ombre_petite administrateur">Supprimer</p>  
                                        </td>
    
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>                                                
                        </table>
                        @else
                        <h4>Il n'y a aucun évènement en attente de validation !</h4>
                        @endif
                    </div>      
                </section>
                @endif --}}


                <div id="info" class="popup">
                    <div class="documentation card">
                        <div class="contenu_doc" id="contenu_doc">
                            <h2>Attention !</h2>
                            <p id="message">Vous êtes sur le point de supprimer un évènement. </p>
                            <p style='font-style:italic;'>Cette action est irréversible.</p>
                        </div>

                        <div style="display:flex;">
                            <div id="gerer"></div>
                            <p class="bouton secondaire info_bouton ombre_petite" style="margin:15px;">Annuler</p>
                        </div>

                    </div>
                </div>
    </main>


    <script> 
        events = {!! json_encode($evenements) !!}

        const listener_click_retour = document.querySelectorAll('.info_bouton');

        listener_click_retour.forEach((listener_click_retour, index) => {
            listener_click_retour.addEventListener("click", function() {
                refresh();

                document.getElementById("info").classList.remove("visible");
            });
        });


        listener_events(events);

        function listener_events(events) {
            const listener_click_events = document.querySelectorAll('.suppression_event');
            listener_click_events.forEach((listener_click_event, index) => {
                listener_click_event.addEventListener("click", function() {
                    afficher_informations_supplementaires(index, events);
                });
            });
        }

        function afficher_informations_supplementaires(index_event, events) {
            refresh();
            //document.getElementById('info').style.top = event.clientX + "px";
            document.getElementById("gerer").innerHTML += `
            <form method="POST" action="evenement/suppression/${ events[index_event]['id']}">
                @csrf
                <button type="submit" name="id" value=${events[index_event]['id']} class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
            </form>`;
            document.getElementById("message").innerText += " Voulez-vous vraiment supprimer : « " + events[
                index_event]["titre"] + " » ?";

            document.getElementById("info").classList.add("visible");
        }

        // Fin partie BDE

        function refresh() {
            document.getElementById("message").innerText = 'Vous êtes sur le point de supprimer un évènement.';
            document.getElementById("gerer").innerHTML = "";
        }
    </script>

@endsection
