@extends('layouts.app')

@pushonce('styles')
    @vite([
        'resources/css/accueil.scss',
        'resources/css/components/service.scss',
        'resources/css/components/post.scss',
        'resources/css/components/switch-campus.scss',
    ])
@endpushonce

@section('content')

    {{-- Contenu principal de la page --}}
    <main id="main-content">

        @if (Auth::check())
            <x-switch-campus :campus="$site"></x-switch-campus>
        @endif

        <section id="section-services">
            <h1>Services</h1>

            <div class="services-wrapper">
                @if (Auth::check() &&
                        Auth::user()->campus->pluck('label')->contains('douai'))
                    <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800
                        logo="{{ Vite::Image('piwigo.png')}} ">
                    </x-service>
                @endif


                <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272
                    logo="{{ Vite::Image('peertube.png') }}">
                </x-service>

                {{-- <x-service nom="AIRplace" destination='https://airplace.etu.imt-nord-europe.fr' color=#cc3345
                    logo="{{ Vite::Image('airplace.png') }}">
                </x-service> --}}

                <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                    logo="{{ Vite::Image('gitlab.png') }}">
                </x-service>

                <x-service nom="Tutoriels HypAIR" destination='https://partage.imt.fr/index.php/s/bH7fpPMqdCmGtAX'
                    color=#4c4372 logo="{{ Vite::Image('tutorial.png') }}">
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

                    @if(!$allPostsVisible)
                        <a href="/posts" id="voir-plus">Voir plus</a>
                    @endif
                @elseif (Auth::check())
                    <p class="should-be-connected no-content">Aucun post pour le moment</p>
                @else
                    <p class="should-be-connected no-content">Vous devez être connecté pour voir les posts</p>
                @endif

            </div>
        </section>

    </main>
@endsection
