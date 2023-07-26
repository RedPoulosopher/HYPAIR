@extends('layouts.app')

@section('titre', 'Accueil')

@pushonce('styles')
    <link rel="stylesheet" href="/css/accueil.css" type="text/css" />
@endpushonce

@section('content')

    <!-- Contenu principal de la page -->
    <main id="main-content">

        <section>
            <h1>Services</h1>

            <div class="services-wrapper">

                <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800 logo='/images/piwigo.png'></x-service>
                <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272 logo='/images/peertube.png'></x-service>
                <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329 logo='/images/gitlab.png'></x-service>

            </div>
        </section>

        <section>
            <h1>Actualités</h1>

            <div class="article-wrapper">
                @php
                    // Dans le futur : récupérer ces infos à partir de la partie backend (Coucou Arthur...)
                    $events = [['Intro à Git', "l'Air"], ['Shotgun Allô Bouffe', 'BDS'], ["Finale de l'IM'Tremplin", "IM'Tremplin"]];
                @endphp

                @for ($i = 0; $i < sizeof($events); $i++)
                    <x-event :index="$i" :title="$events[$i][0]" :author="$events[$i][1]" />
                @endfor

            </div>
        </section>

    </main>

@endsection
