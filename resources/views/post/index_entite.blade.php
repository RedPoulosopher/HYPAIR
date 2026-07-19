@extends('layouts.app-without-sidebar')

@section('titre', 'Post')

@pushonce('styles')
    @vite([
        'resources/css/post/home-post.scss',
        'resources/css/components/service.scss',
        'resources/css/components/post.scss',
        'resources/css/documentation-popup.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>Posts</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue sur la page concernant les posts !</p>
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
                    <a href="post/create" class="bouton tertiaire ombre_petite administrateur">
                        <span><i class="fa-solid fa-plus"></i>Créer un post</span>
                    </a>
                </div>

                <h2>Liste des posts :</h2>

                @if (count($posts) > 0)
                    <ul id="posts-list">
                        @foreach ($posts as $post)
                            <li>
                                <x-post :post="$post" :id="$post->uid" />

                                <a href="post/modifier/<?= $post->uid ?>" class="bouton_action"
                                    style="color:black; border-color:black;">
                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                </a>

                                <span class="bouton_action warning suppression_post">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="no-content">Aucun post pour le moment</p>
                @endif

                <div id="info" class="popup">
                    <div class="documentation card">
                        <div class="contenu_doc" id="contenu_doc">
                            <h2>Attention !</h2>
                            <p id="message">Vous êtes sur le point de supprimer un post. </p>
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
        posts = {!! json_encode($posts) !!}

        const listener_click_retour = document.querySelectorAll('.info_bouton');

        listener_click_retour.forEach((listener_click_retour, index) => {
            listener_click_retour.addEventListener("click", function() {
                refresh();

                document.getElementById("info").classList.remove("visible");
            });
        });


        listener_posts(posts);

        function listener_posts(posts) {
            const listener_click_posts = document.querySelectorAll('.suppression_post');
            listener_click_posts.forEach((listener_click_post, index) => {
                listener_click_post.addEventListener("click", function() {
                    afficher_informations_supplementaires(index, posts);
                });
            });
        }

        function afficher_informations_supplementaires(index_post, posts) {
            refresh();
            //document.getElementById('info').style.top = event.clientX + "px";
            document.getElementById("gerer").innerHTML += `
            <form method="POST" action="post/suppression/${ posts[index_post]['uid']}">
                @csrf
                <button type="submit" name="uid" value=${posts[index_post]['uid']} class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
            </form>`;
            document.getElementById("message").innerText += " Voulez-vous vraiment supprimer : « " + posts[
                index_post]["title"] + " » ?";

            document.getElementById("info").classList.add("visible");
        }

        // Fin partie BDE

        function refresh() {
            document.getElementById("message").innerText = 'Vous êtes sur le point de supprimer un évènement.';
            document.getElementById("gerer").innerHTML = "";
        }
    </script>

@endsection
