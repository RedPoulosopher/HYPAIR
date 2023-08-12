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

        <section id="section-services">
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
                    <x-post :post="$posts[$i]"/>
                @endfor

            </div>
        </section>
        
    </main>
@endsection
