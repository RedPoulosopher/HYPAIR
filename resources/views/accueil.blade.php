@extends('layouts.app')

@section('titre', 'Accueil')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/accueil.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/service.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/post.css') }}" type="text/css" />
@endpushonce

@section('content')

    {{-- Contenu principal de la page --}}
    <main id="main-content">

        <section>
            <h1>Services</h1>

            <div class="services-wrapper">

                <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800
                    logo="{{ mix('/images/piwigo.png') }}">
                </x-service>

                <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272
                    logo="{{ mix('/images/peertube.png') }}">
                </x-service>
                
                <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                    logo="{{ mix('/images/gitlab.png') }}">
                </x-service>

            </div>
        </section>

        <section>
            <h1>Actualités</h1>

            <div class="article-wrapper">

                @for($i = 0; $i < count($posts); $i++)
                    <x-post :post="$posts[$i]" :id="$i" />
                @endfor

            </div>
        </section>

    </main>

    <script>
        // Ce script commande l'affichage des descriptions des posts

        // Ajouter un EventListener sur chaque flèche rouge
        arrows = document.getElementsByClassName("arrow")

        // Cacher les descriptions des posts
        descriptions = document.getElementsByClassName("description")
        for (let i = 0; i < arrows.length; i++) {
            descriptions[i].style.display = "none"
        }

        // Commander l'affichage des descriptions
        for (let i = 0; i < arrows.length; i++) {
            arrows[i].addEventListener("click", (event) => {

                elementName = event.target.id
                console.log(elementName)
                descriptionName = "description"

                if (elementName != "") {
                    number = elementName.split('-')[1]
                    descriptionName = descriptionName + '-' + number

                    console.log(descriptionName)
                    console.log(number)

                    description = document.getElementById(descriptionName)
                    
                    if (description.style.display === "none") {
                        description.style.display = "block"
                    } else {
                        description.style.display = "none"
                    }
                }

            })
        }
    </script>

@endsection
