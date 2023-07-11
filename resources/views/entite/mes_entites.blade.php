@extends('layouts.app')

@section('titre', 'Mes entités')

@section('content')
<!-- Contenu principal de la page -->
<main id="main-content">

    <section>
        <h1>Mes entités</h1>

        <div class="entites-wrapper">
            
            <a href="/calendrier" class="service">
                <img src="/images/logo_services/calendrier.png" alt="logo_calendrier" id="calendrier">
                <p>Calendrier</p>
            </a>

            <a href="https://photos.imt-ne.fr" class="service" target="_blank">
                <img src="/images/logo_services/piwigo.png" alt="logo_piwigo" id="piwigo">
                <p>Photos</p>
            </a>

        </div>
    </section>
    


</main>

@endsection