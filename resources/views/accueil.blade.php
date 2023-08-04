@extends('layouts.app')

@section('titre', 'Accueil')

@pushonce('styles')
    <link rel="stylesheet" href="/css/accueil.css" type="text/css" />
@endpushonce

@section('content')

    {{-- Contenu principal de la page --}}
    <main id="main-content">

        <section>
            <h1>Services</h1>

            <div class="services-wrapper">

                <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800 logo='/images/piwigo.png'>
                </x-service>
                <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272 logo='/images/peertube.png'>
                </x-service>
                <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                    logo='/images/gitlab.png'></x-service>

            </div>
        </section>

        <section>
            <h1>Actualités</h1>

            <div class="article-wrapper">

                @foreach ($posts as $post)
                    <x-post :post="$post" />
                @endforeach

            </div>
        </section>

    </main>

@endsection
