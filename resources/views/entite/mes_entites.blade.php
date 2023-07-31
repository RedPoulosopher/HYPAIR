@extends('layouts.app')

@section('titre', 'Mes entités')

@pushonce('styles')
<link rel="stylesheet" href="css/mes_entites.css" type="text/css" />
@endpushonce

@section('content')
<!-- Contenu principal de la page -->
<main id="main-content">

    <section>
        <h1>Mes entités</h1>

        <div class="entites-wrapper">
            @if (Auth::check())
                @foreach ($entites as $entite)
                    <x-entite :asso="$entite" :destination="$entite->lien_gestion_relatif()" />
                @endforeach
            @endif

        </div>

        <h1>Mes évènements</h1>
        @foreach ($events as $event)
        <x-event :event="$event"/>
        @endforeach
    </section>
    


</main>

@endsection