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
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestionnaire des Pôles</h1>

		    <div style="margin-bottom: 25px">
                <a href="{{ route("create_role",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Retour</a>
                <a href="{{ route("create_pole",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Créer un pôle</a>
            </div>

            <div class="section-content">
                @if (!is_null($list_poles) && count($list_poles) > 0)
                    <div class="table card">
                        <table id="index">
                            <thead>
                                <tr>
                                    <th>Pôle</th>
                                    <th>Priorité d'affichage</th>
                                    <th width="35%">Modifier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_poles as $pole)
                                    <tr class="ligne_membre">
                                        <td>{{ $pole->name }}</td>
                                        <td>{{ $pole->ordre }}</td>
                                        @if($pole->create_by!=null)
                                            <td class="icons">
                                                <a class="fa-solid fa-pen-to-square fa-lg" title="Modifier"
                                                    href="{{ route("edit_pole",[ $entite->uid,$pole->uid ]) }}">
                                                </a>
                                                <a class="warning fa-solid fa-trash fa-lg" title="Supprimer"
                                                    pole_uid="{{ $pole->uid }}"
                                                    pole_name="{{ $pole->name }}"
                                                    onclick="demander_suppression(this)">
                                                </a>
                                            </td>
                                        @else
                                            <td>Default</td>
                                        @endif
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

        // Bouton suppresion
        function demander_suppression(membre) {
            document.getElementById("gerer").innerHTML = `
            <form method="POST" action="{{ route("delete_pole",[$entite->uid]) }}">
                @csrf
                <input name="pole_uid" value="${membre.getAttribute('pole_uid')}" style="display:none">
                <button type="submit" class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
            </form>`;
            document.getElementById("message").innerText = " Voulez-vous vraiment supprimer le rôle de « " + membre.getAttribute('pole_name') + " » ?";

            document.getElementById("info").classList.add("visible");
        }

        function retour(){
            document.getElementById("info").classList.remove("visible");
        }
    </script>
@endsection
