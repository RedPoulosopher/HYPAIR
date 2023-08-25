@extends('layouts.app')

@section('titre', 'À propos')

@section('content')

    @pushonce('styles')
        <link rel="stylesheet" href="{{ mix('/css/a-propos.css') }}">
    @endpushonce

    <main id="main-content">
        <section>
            <h1>À propos de HypAIR</h1>
            <article>
                <p>HypAIR c'est LE site associatif de l'IMT Nord Europe. Tu y trouveras les infos sur chaque comité,
                    breau, évènement à venir...
                    Nous voulons être présents à Lille comme à Douai, et à l'avenir, on l'espère, sur tous les campus !</p>
                <p>Le développement d'HypAIR a débuté il y a 3 ans, mais il reste encore beaucoup d'améliorations à apporter. Donc n'hésitez
                    pas à nous faire des retours sur votre ressenti et sur les nouveautés que vous aimeriez voir !</p>
                <p>Si vous êtes chauds en dessin et souhaitez nous aider, n'hésitez pas à tenter de créer un logo pour HypAIR.
                    Si nous le sélectionons, tu auras le droit à ton nom plaqué or pendant une semaine sur la page d'accueil :)</p>
                <p>Si vous voulez nous aider à développer le site tout au long de l'année ainsi que participer à de nombreux autres
                    projets, faites le nous savoir et rejoignez nos réseaux : <a href="/air">https://hypair.imt-ne.fr/air</a></p>
            </article>
        </section>
    </main>

@endsection
