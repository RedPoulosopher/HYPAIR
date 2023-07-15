@extends('layouts.app')

@section('titre', 'Accueil')

@pushonce('styles')
<link rel="stylesheet" href="css/accueil.css" type="text/css" />
@endpushonce

@section('content')

<!-- Contenu principal de la page -->
<main id="main-content">

    <section>
        <h1>Services</h1>

        <div class="services-wrapper">
            
            <a href="/calendrier" class="service">
                <img src="/images/logo_services/calendrier.png" alt="logo_calendrier" id="service-calendrier">
                <p>Calendrier</p>
            </a>

            <a href="https://photos.imt-ne.fr" class="service" target="_blank">
                <img src="/images/logo_services/piwigo.png" alt="logo_piwigo" id="service-piwigo">
                <p>Photos</p>
            </a>

            <a href="https://peertube.imt-ne.fr" class="service" target="_blank">
                <img src="/images/logo_services/peertube.png" alt="logo_peertube" id="service-peertube">
                <p>Vidéos</p>
            </a>

            <a href="https://gitlab.etu.imt-nord-europe.fr" class="service" target="_blank">
                <img src="/images/logo_services/gitlab.png" alt="logo_gitlab" id="service-gitlab">
                <p>GitLab</p>
            </a>

        </div>
    </section>
    

    <section>
        <h1>Actualités</h1>

        <div class="article-wrapper">
            @php
                // Dans le futur : récupérer ces infos à partir de la partie backend (Coucou Arthur...)
                $events = [
                    ["Intro à Git", "l'Air"], 
                    ["Shotgun Allô Bouffe", "BDS"],
                    ["Finale de l'IM'Tremplin", "IM'Tremplin"]
                ]
            @endphp

            @for($i = 0; $i < sizeof($events); $i++)
                <x-event :index="$i" :title="$events[$i][0]" :author="$events[$i][1]" />
            @endfor
            
        </div>
    </section>

</main>

@endsection