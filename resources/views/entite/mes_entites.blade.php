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
            
            <a href="/air">Test entité AIR</a>
            <a href="/bdh">Test entité BDH</a>

        </div>
    </section>
    


</main>

@endsection