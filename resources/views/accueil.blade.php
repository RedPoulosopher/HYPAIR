@extends('layouts.app')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/accueil.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/service.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/post.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ mix('/css/components/switch-campus.css') }}" type="text/css" />
@endpushonce

@section('content')

    {{-- Contenu principal de la page --}}
    <main id="main-content">

        @if (Auth::check())
            <x-post-switch-campus :campus="$site"></x-post-switch-campus>
        @endif

        <section id="section-services">
            <h1>Services</h1>

            <div class="services-wrapper">
                @if (Auth::check() &&
                        Auth::user()->campus->pluck('label')->contains('douai'))
                    <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800
                        logo="{{ mix('/images/piwigo.png') }}">
                    </x-service>
                @endif

                <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272
                    logo="{{ mix('/images/peertube.png') }}">
                </x-service>

                <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                    logo="{{ mix('/images/gitlab.png') }}">
                </x-service>

                <x-service nom="Tutoriels HypAIR" destination='https://partage.imt.fr/index.php/s/bH7fpPMqdCmGtAX'
                    color=#4c4372 logo="{{ mix('/images/tutorial.png') }}">
                </x-service>

            </div>
        </section>

        <section>
            <h1>Actualités</h1>

            <div class="article-wrapper">
                @if (Auth::check() && count($posts) > 0)
                    @foreach ($posts as $post)
                        @if (!$post->confidentiel || ($post->confidentiel && $canSeeConfidentiel))
                            <x-post :post="$post" />
                        @endif
                    @endforeach
                @elseif (Auth::check())
                    <p class="should-be-connected no-content">Aucun post pour le moment</p>
                @else
                    <p class="should-be-connected no-content">Vous devez être connecté pour voir les posts</p>
                @endif

            </div>
        </section>

    </main>
@endsection
