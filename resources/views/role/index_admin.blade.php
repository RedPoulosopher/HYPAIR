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
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestion des Rôles</h1>

		    <div>
                <a href="{{ route("dashboard",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Retour</a>
                <a href="{{ route("index_role",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Gestionnaire des rôles</a>
            </div>

            <div class="section-content">
                <h2>Ajouter un membre :</h2>
                <form method="POST" action="{{ route("give_role_user",[$entite->uid]) }}">
                    @csrf
                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Nom du membre :</p>
                            <p class="description">Rentrer le nom de la personne.</p>
                            <input id="user_name" type="text" name="user_name" required class="input"
                                value="{{ old('user_name') ?? '' }}" list="users-list" autocomplete="off" />
                            <input id="user_uid" type="text" name="user_uid" required class="input"
                                value="{{ old('user_uid') ?? '' }}" autocomplete="off" style="display: none"/>
                            <datalist id="users-list">
                                @foreach($listUsers as $user)
                                    <option value="{{ $user->prenom }} {{ $user->nom }}" data-uid="{{ $user->uid }}">
                                        {{ $user->prenom . " " . $user->nom}}</option>
                                @endforeach
                            </datalist>
                        </label>
                        <div class="input_groupe">
                            <p class="titre">Rôle du membre :</p>
                            <select class="input" id="role-input" name="role_uid">
                                @foreach ($list_roles as $role)
                                    <option value="{{ $role->uid }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            <p id="droits-role">
                            </p>
                        </div>
                        <div style="display:flex;justify-content: flex-end;">
                            <button type="submit" class="bouton primaire valider_role">VALIDER</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="section-content">
                <h2>Membres actuels :</h2>
                @if (!is_null($roles) && count($roles) > 0)
                    <div class="table card">
                        <table id="index">
                            <thead>
                                <tr>
                                    <th width="20%">Prénom</th>
                                    <th>Nom</th>
                                    <th>Rôle</th>
                                    <th>Pôle</th>
                                    <th>Modifier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr class="ligne_membre">
                                        <td>{{ $role->user['prenom'] }}</td>
                                        <td>{{ $role->user['nom'] }}</td>
                                        <td><span class="role">{{ $role->role['name'] }}</span></td>
                                        <td><span class="role">{{ $role->role->pole['name'] ?? "Sans Pôle" }}</span></td>
                                        <td class="icons">
                                            <a class="warning fa-solid fa-trash fa-lg" title="Supprimer"
                                                role_uid="{{ $role->role['uid'] }}"
                                                user_uid="{{ $role->user['uid'] }}"
                                                role_name="{{ $role->role['name'] }}"
                                                user_name="{{ $role->user['prenom'] . " " . $role->user['nom'] }}"
                                                onclick="demander_suppression_membre(this)">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div id="info" class="popup">
                <div class="documentation card">
                    <div class="contenu_doc" id="contenu_doc">
                        <h2>Attention !</h2>
                        <p id="message">Vous êtes sur le point de supprimer un rôle. </p>
                    </div>

                    <div style="display:flex;">
                        <div id="gerer"></div>
                        <p class="bouton secondaire info_bouton ombre_petite" style="margin:15px;" onclick="retour()">Annuler</p>
                    </div>

                </div>
            </div>
        </section>
    </main>

    
    <script>
        // Affichage des droits du rôle
        var roles = {!! json_encode($roles) !!}
        var roleInput = document.getElementById('role-input');
        var droitDuRole = document.getElementById('droits-role');


        document.getElementById('user_name').addEventListener('input', function () {
            const value = this.value;
            const options = document.querySelectorAll('#users-list option');
            const uidInput = document.getElementById('user_uid');

            uidInput.value = '';

            options.forEach(option => {
                if (option.value === value) {
                    uidInput.value = option.dataset.uid;
                }
            });
        });

        roleInput.addEventListener('change', (event) => {
            var id = roleInput.value - 1;

            var text =
                `${roles[id].gerer_post == 1 ? 'les posts, ' : ''}${roles[id].gerer_evenement == 1 ? 'les évènements, ' : ''}${roles[id].gerer_entite == 1 ? 'l\'entite, ' : ''}${roles[id].gerer_membre == 1 ? 'les membres, ' : ''}${roles[id].gerer_reseau == 1 ? 'les réseaux sociaux, ' : ''}`
            console.log(roles[id].gerer_evenement == 1)
            droitDuRole.innerText = (text.length > 0 ? "Peut gérer " : '') + text.slice(0, -2) //remove last comma
        })


        // Bouton suppresion
        function demander_suppression_membre(membre) {
            document.getElementById("gerer").innerHTML = `
            <form method="POST" action="{{ route("give_role_user",[$entite->uid]) }}">
                @csrf
                <input name="user_uid" value="${membre.getAttribute('user_uid')}" style="display:none">
                <input name="role_uid" value="${membre.getAttribute('role_uid')}" style="display:none">
                <input name="type" value="supp" style="display:none">
                <button type="submit" class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
            </form>`;
            document.getElementById("message").innerText = " Voulez-vous vraiment retirer le rôle « " + membre.getAttribute('role_name') + " » à " + membre.getAttribute('user_name') + " ?";

            document.getElementById("info").classList.add("visible");
        }

        function retour(){
            document.getElementById("info").classList.remove("visible");
        }
    </script>
@endsection
