@extends('layouts.app')

@section('titre', 'Évènement')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/home-evenement.css') }}" type="text/css">
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


                @if ($gerer_evenement)
                    <div class="create-btn-container">
                        <a href="evenement/formulaire" class="bouton tertiaire ombre_petite administrateur">
                            <span><i class="fa-solid fa-plus"></i>Créer un évènement</span>
                        </a>
                    </div>
                @endif

                <h2>Liste des évènements :</h2>
                @if (count($tables) != 0)
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
                                @foreach ($tables as $table)
                                    <tr>
                                        <td><?= $table['titre'] ?></td>
                                        <td><?= $table['temps_debut'] ?></td>
                                        <td><?= $table['temps_fin'] ?></td>
                                        <td><?= $table['lieu'] ?></td>

                                        {{-- <td><?= $table['max_participation'] ?></td>
                                        
                                        @if ($table['pour_cotisant'] == 0)
                                            <td>Oui</td>
                                        @else
                                            if ($table['pour_cotisant'] == 1)
                                                <td>Non</td>
                                        @endif --}}


                                        {{-- @if ($table['confidentialite'] == 0)
                                            <td>Public</td>
                                        @elseif ($table['confidentialite'] == 1)
                                            <td>Membres de l'assos</td>
                                        @elseif ($table['confidentialite'] == 2)
                                            <td>Responsables & bureau</td>
                                        @elseif ($table['confidentialite'] == 3)
                                            <td>Bureau</td>
                                        @elseif ($table['confidentialite'] == 4)
                                            <td>Prez & vice-prez</td>
                                        @endif --}}

                                        {{-- @if ($table['confidentialite'] == 0)
                                            @if ($table['validation'] == 1)
                                                <td>Validé</td>
                                            @elseif ($table['validation'] == 0)
                                                <td>En attente de validation</td>
                                            @endif
                                        @else
                                            <td>/</td>
                                        @endif --}}

                                        <td>
                                            <a href="evenement/modifier/<?= $table['id'] ?>" class="bouton_action"
                                                style="color:black; border-color:black;">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($gerer_evenement)
                                                <a href="evenement/suppression">
                                                    {{-- {{ dd($table) }} --}}
                                                    <a href="evenement/suppression/{{ $table->id }}">
                                                        <span class="bouton_action warning">
                                                            <i class="fa-solid fa-trash fa-lg"></i>
                                                        </span>
                                                    </a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h4>Il n'y a aucun évènement prévu !</h4>
                @endif


                {{-- @if ($entite == 'bde' && in_array(13, $entite_user) && $gerer_evenement == 1)
                    <div class="groupe card">
                        <h2>Liste des évènements en attente de validation</h2>

                        @if (count($tables_attente_validation) != 0)
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
                                </tbody>                                                
                        </table>
                        @else
                        <h4>Il n'y a aucun évènement en attente de validation !</h4>
                        @endif
                    </div>      
                </section>
                @endif --}}


                <div id="info" class="popup">
                    <div class="documentation ombre_petite">
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
        events = {!! json_encode($tables) !!}

        const listener_click_retour = document.querySelectorAll('.info_bouton');

        listener_click_retour.forEach((listener_click_retour, index) => {
            listener_click_retour.addEventListener("click", function() {
                refresh();

                document.getElementById("info").classList.add("popup");
            });
        });


        listener_events(events);

        function listener_events(evenements) {
            const listener_click_evenements = document.querySelectorAll('.suppression_entite');
            listener_click_evenements.forEach((listener_click_evenement, index) => {
                listener_click_evenement.addEventListener("click", function() {
                    afficher_informations_supplementaires(index, evenements);
                });
            });
        }

        // Attention : une partie sur les évènements en attente a été supprimée

        function afficher_informations_supplementaires(index_evenement, evenements) {
            refresh();
            //document.getElementById('info').style.top = event.clientX + "px";
            document.getElementById("gerer").innerHTML += `
            <form method="POST" action="evenement/suppression">
                @csrf
                @if ($gerer_evenement)
                    <button type="submit" name="id" value=` + evenements[index_evenement]['id'] + ` class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
                @endif
            </form>`;
            document.getElementById("message").innerText += " Voulez-vous vraiment supprimer : « " + evenements[
                index_evenement]["titre"] + " » ?";

            document.getElementById("info").classList.remove("popup");
        }

        // Fin partie BDE

        function refresh() {
            document.getElementById("message").innerText = 'Vous êtes sur le point de supprimer un évènement.';
            document.getElementById("gerer").innerHTML = "";
        }
    </script>

@endsection
