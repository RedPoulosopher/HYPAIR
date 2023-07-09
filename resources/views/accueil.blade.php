@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

<!-- Contenu principal de la page -->
<main id="main-content">

    <section>
        <h1>Outils</h1>

        <div class="services-wrapper">
            
            <div class="service-container">
                <a href="/calendrier" class="service-ombre-petite">
                    <div class="cercle" style="border-color: #e74c3c"></div>
                    <img src="/images/logo_services/calendrier.png" alt="logo_calendrier" height="80">
                </a>
                <p>Calendrier</p>
            </div>

            <div class="service-container">
                <a href="https://photos.imt-ne.fr" class="service-ombre-petite" target="_blank">
                    <div class="cercle" style="border-color: #e74c3c"></div>
                    <img src="/images/logo_services/piwigo.png" alt="logo_piwigo" height="80">
                </a>
                <p>Photos</p>
            </div>

            <div class="service-container">
                <a href="https://peertube.imt-ne.fr" class="service-ombre-petite" target="_blank">
                    <div class="cercle" style="border-color: #e74c3c"></div>
                    <img src="/images/logo_services/peertube.png" alt="logo_peertube" height="80">
                </a>
                <p>Vidéos - PeerTube</p>
            </div>

            <div class="service-container">
                <a href="https://gitlab.etu.imt-nord-europe.fr" class="service-ombre-petite" target="_blank">
                    <div class="cercle" style="border-color: #e74c3c"></div>
                    <img src="/images/logo_services/gitlab.png" alt="logo_gitlab" height="80">
                </a>
                <p>GitLab</p>
            </div>

        </div>
    </section>
    

    <section>
        <h1>Actualités</h1>

        <div class="article-wrapper">
            @php
                // Dans le futur : récupérer ces infos à partir de la partie backend
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