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
            <x-switch-campus :campus="$site"></x-switch-campus>
        @endif

        <section>
            <h1>Posts</h1>

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
