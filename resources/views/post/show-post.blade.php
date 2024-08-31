@extends('layouts.app')

@section('titre', $post->titre)

@pushonce('opengraph')
    <meta property="og:title" content="{{ $entite->nom }} - {{ $post->titre }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{Request::url()}}" />
    @if(count($post->bannieres) > 0)
    <meta property="og:image" content="{{ url(Storage::url($post->bannieres[0]->path)) }}" />
    @endif
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:site_name " content="HypAIR" />
    @isset($post->description)
    <meta property="og:description" content="{!! Str::limit(strip_tags(Str::markdown(strip_tags($post->description ?? ''))), 60, '...') !!}" />
    @endisset
@endpushonce

@pushonce('styles')
    {{-- <link rel="stylesheet" href="{{ mix('/css/evenements/show-evenement.css') }}" type="text/css" > --}}
    <link rel="stylesheet" href="{{ mix('/css/post/show-post.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/documentation-popup.css') }}" type="text/css" />
@endpushonce

@section('content')

    @php
        use App\Http\Controllers\PostController;
    @endphp

    <main id="main-content">
        <section class="section-content">
            <h1>Infos du post</h1>

            <div style="display:flex;">
                <a onclick="history.back()" class="bouton secondaire ombre_petite" style="margin:0 0 15px;">
                    < Retour</a>


                        <!--
                       @if ($gerer_post)
    <a href="/post/modifier/{{ $post->id }}" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Modifier</a>
    @endif
                    -->
            </div>

            @if (Auth::check())
                <div class="documentation card">
                    @if ($postIsVisible && $canSeePost)
                        <i id="share-btn" class="fa-solid fa-arrow-up-right-from-square"></i>

                        <div class="header">
                            <div class="thumbnail"><img src="{{ session('entite_logo_petit') }}" alt="Logo {{ $entite->nom }}">
                            </div>
                            <h1 class="title">{{ $post->titre }}</h1>
                            <p>Posté par {{ $entite->nom }}<span class="separator">•</span>{{ PostController::date_apparition_to_duration($post->date_apparition) }}</p>
                            @if ($post->confidentiel != 0)
                                <p id="confidentiel" title="Ce post n'est visible que pour votre campus. Ne pas partager"
                                    class="tooltip"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Ce post est
                                    confidentiel</p>
                            @endif

                            <div class="tags">
                                @foreach ($post->tags as $tag)
                                    <div class="tag" style="background-color: {{ $tag->couleur }};">{{ $tag->name }}</div>
                                @endforeach
                            </div>
                            @if ($post->event)
                                <a id="rattachement"
                                    href="/{{ $post->entite->uid }}/entite/evenement/{{ $post->event->slug }}"><i
                                        class="fa-solid fa-link"></i>Ce post est rattaché à l'évènement
                                    "{{ $post->event->titre }}"</a>
                            @endif
                        </div>

                        <div class="img-container">
                            @foreach ($post->bannieres as $banniere)
                                <img src="{{ Storage::url($banniere->path) }} " alt="bannière">
                            @endforeach
                        </div>
                        <div class="description">
                            {!! Str::markdown(strip_tags($post->description ?? '')) !!}
                        </div>
                    @elseif (!$postIsVisible)
                        <p id="confidentiel"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Ce post n'est pas disponible
                        </p>
                    @else
                        <p id="confidentiel"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Ce post est confidentiel. Vous ne pouvez pas le consulter.</p>
                    @endif
                </div>
            @else
                <div class="documentation card">
                    <p id="confidentiel"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Veuillez vous connecter pour voir le post.</p>
                    <div id="connect">
                        <a href="/home" class="bouton primaire ombre_petite">Se connecter</a>
                    </div>
                </div>
            @endif
        </section>
    </main>

@endsection

@pushonce('end-scripts')
    <script>
        shareBtn = document.getElementById("share-btn")

        function copierLien() {
            navigator.clipboard.writeText(window.location.href);
            alert("Lien copié dans le presse-papier")
        }

        shareBtn.addEventListener('click', () => {
            if (window.matchMedia("(max-width: 710px)").matches && navigator
                .share) { //Montre l'API share sur mobile si possible
                navigator.share({
                    title: '{{ $post->titre }} - HypAIR',
                    text: "[Post - {{ $post->titre }}]\nVoir sur HypAIR :",
                    url: window.location.href,
                })
            } else {
                copierLien();
            }
        })
    </script>
@endpushonce
