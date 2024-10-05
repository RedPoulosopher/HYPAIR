@extends('layouts.app-without-sidebar')

@section('titre', 'Membres')

@pushonce('styles')
    @vite([
        'resources/css/jstable.scss',
        'resources/css/formulaire.scss',
        'resources/css/documentation-popup.scss',
        'resources/css/membre/index_admin.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestion des Membres
            </h1>

            <div class="section-content">
                <h2>Ajouter un membre :</h2>
                <form method="POST">
                    @csrf
                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Uid du membre :</p>
                            <p class="description">Rentrer l'identifiant de la personne. C'est le début de son adresse mail,
                                souvent "prenom.nom".</p>
                            <input id="user_uid" type="text" name="user_uid" required class="input"
                                value="{{ old('user_uid') ?? '' }}" />
                        </label>
                        <div class="input_groupe">
                            <p class="titre">Rôle du membre :</p>
                            {{-- <input type="hidden" id="search_role_input_id" name="role_id"> --}}
                            {{-- <input class="input" id="search_role_input" name="role_name"> --}}
                            <select class="input" id="role-input" name="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->label) }}</option>
                                @endforeach
                                <option value="">Aucun</option>
                            </select>
                            {{-- <div id="roles">
                            <p style="display:none">aucun rôle ne correspond à cette recherche. Contactez l'AIR pour le rajouter.</p>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach 
                        </div> --}}
                            <p id="droits-role">
                            </p>
                        </div>
                        <div style="display:flex;justify-content: flex-end;">
                            <button type="submit" class="bouton primaire valider_role">VALIDER</span></button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- <div id="choix_role">
                <a href="membres" class="bouton secondaire">Membres</a>
                <a href="abonnes" class="bouton secondaire">Abonnés</a>
            </div> --}}
            <div class="section-content">
                <h2>Membres actuels :</h2>
                @if (!is_null($personnes_concernees) && count($personnes_concernees) > 0)
                    <div class="table card">
                        <table id="index">
                            <thead>
                                <tr>
                                    <th width="35%">Prénom</th>
                                    <th>Nom</th>
                                    <th>Rôle</th>
                                    <th>Modifier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personnes_concernees as $membre)
                                    <tr class="ligne_membre">
                                        <td>{{ $membre['prenom'] }}</td>
                                        <td>{{ $membre['nom'] }}</td>
                                        <td><span class="role">{{ $membre['label'] }}</span></td>
                                        <td class="icons">
                                            <a class="fa-solid fa-pen-to-square fa-lg" title="Modifier"
                                                membre_id="{{ $membre['id'] }}" role_id="{{ $membre['roles.id'] }}"
                                                user_uid="{{ $membre['uid'] }}"
                                                onclick="afficher_menu_membre(this)">
                                            </a>
                                            <a class="warning fa-solid fa-trash fa-lg" title="Supprimer"
                                                membre_id="{{ $membre['id'] }}" membre_label="{{ $membre['label'] }}"
                                                membre_nom_complet="{{ $membre['prenom'] . ' ' . $membre['nom']}}"
                                                onclick="demander_suppression_membre(this)">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($creation)
                    <a href="{{ $entite_lien_relatif}}" class="bouton secondaire" style="float:right; margin: 20px 0 0">Terminer la création</a>
                @endif
            </div>

            <div id="info" class="popup">
                <div class="documentation card">
                    <div class="contenu_doc" id="contenu_doc">
                        <h2>Attention !</h2>
                        <p id="message">Vous êtes sur le point de supprimer un évènement. </p>
                        <p style='font-style:italic;'>Cette action est irréversible.</p>
                    </div>

                    <div style="display:flex;">
                        <div id="gerer"></div>
                        <p class="bouton secondaire info_bouton ombre_petite" style="margin:15px;" onclick="retour()">Annuler</p>
                    </div>

                </div>
            </div>
        </section>
    </main>

    
    <script type="module">
        // Affichage des droits du rôle
        var roles = {!! json_encode($roles) !!}
        var roleInput = document.getElementById('role-input');
        var droitDuRole = document.getElementById('droits-role');

        roleInput.addEventListener('change', (event) => {
            var id = roleInput.value - 1;

            var text =
                `${roles[id].gerer_post == 1 ? 'les posts, ' : ''}${roles[id].gerer_evenement == 1 ? 'les évènements, ' : ''}${roles[id].gerer_entite == 1 ? 'l\'entite, ' : ''}${roles[id].gerer_membre == 1 ? 'les membres, ' : ''}${roles[id].gerer_reseau == 1 ? 'les réseaux sociaux, ' : ''}`
            console.log(roles[id].gerer_evenement == 1)
            droitDuRole.innerText = (text.length > 0 ? "Peut gérer " : '') + text.slice(0, -2) //remove last comma
        })



        // Bouton modifier
        var el_user_uid = document.getElementById("user_uid")

        function afficher_menu_membre(ceci) {
            membre_id = ceci.getAttribute("membre_id")
            user_uid = ceci.getAttribute("user_uid")
            role_id = ceci.getAttribute("role_id")

            el_user_uid.value = user_uid
            roleInput.querySelector('[value="' + role_id + '"]').selected = true
        }

        // Bouton suppresion
        function demander_suppression_membre(membre) {
            document.getElementById("gerer").innerHTML = `
            <form method="POST" action="membres/suppression/">
                @csrf
                <button type="submit" name="membre_id" value=${membre.getAttribute('membre_id')} class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
            </form>`;
            document.getElementById("message").innerText = " Voulez-vous vraiment retirer le rôle « " + membre.getAttribute('membre_label') + " » à " + membre.getAttribute('membre_nom_complet') + " ?";

            document.getElementById("info").classList.add("visible");
        }

        function retour(){
            document.getElementById("info").classList.remove("visible");
        }
    </script>
@endsection
