@extends('layouts.app')

@section('titre', 'À propos')

@section('content')

    @pushonce('styles')
        <link rel="stylesheet" href="{{ mix('/css/a-propos.css') }}">
    @endpushonce

    <main id="main-content">
        <section>
            <h1>À propos de l'application HypAIR</h1>
            <article class="card">
                <p>HypAIR est un site qui se veut être un complément (voir un indispensable à l'avenir) à la vie associative
                    en
                    ajoutant des fonctionnalités et des services qui serviront et amélioreront la vie étudiante (calendrier,
                    évènements, posts...) et aussi la pérennité des comités et des associations en centralisant les
                    informations. Nous voulons être présents à
                    Lille comme à Douai, et on l'espère, à l'avenir sur tous les campus !</p>
                <p>Le projet HypAIR est encore à ses débuts. Cela veut donc dire que le site est encore loin d'être fini. Il
                    y a
                    encore beaucoup d'améliorations à apporter et de fonctionnalités que nous avons en tête. Donc n'hésitez
                    pas
                    à nous faire des retours sur votre ressenti et sur les nouveautés que vous aimeriez voir.</p>
                <p>D'ailleurs si quelqu'un est chaud en dessin, on cherche désespérement un logo pour le site. Si une
                    bienveillante personne propose un magnifique logo pour HypAIR, il aura son nom plaqué or pendant une
                    semaine
                    sur la page d'accueil :)</p>
                <p>Si vous voulez nous aider à développer notre site tout au long de l'année vous pouvez nous le faire
                    savoir et
                    rejoindre nos réseaux : <a href="/air">https://hypair.imt-ne.fr/air</a></p>
            </article>
        </section>
    </main>

@endsection
