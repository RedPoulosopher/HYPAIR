@extends('layouts.app')

@section('titre', 'Mes entités')

@pushonce('styles')
<link rel="stylesheet" href="css/mes-entites.css" type="text/css" />
@endpushonce

@section('content')
<!-- Contenu principal de la page -->
<main id="main-content">

    <section>
        <h1>Mes entités</h1>

        <div class="entites-wrapper">
            @if (Auth::check())
                @foreach ($entites as $entite)
                    {{-- <p>{{ $entite }}</p> --}}
                    {{-- {{ $entite->lien_relatif() }} --}}
                    <x-entite :asso="$entite" :destination="$entite->lien_relatif()" />
                @endforeach
            @endif

        </div>
    </section>
    


</main>

@endsection