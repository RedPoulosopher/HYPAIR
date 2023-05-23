@extends('layouts.leger')

@section('titre', 'Accueil')

@section('content')

<style>
    .logo {
        position: relative;
        display: block;
        margin-left:auto;
        margin-right:auto;
        width:260px;
        height:260px;
        border-radius: 20px;
    }

    .logo img {
	width:100%;
	border-radius:300px;
}

#wrapper {
    flex-direction: column;
    overflow-x: hidden;
    min-height: 110%;
}

</style>


    <div id="wrapper">
        <div id="contenu" class="grand">
            <h1 class="titre_page espace">- HYPAIR -</h1>
                <div class="logo">
                    <img
                        src="/images/logo_air_1.png"
                        alt="logo_hypair"
                    />
                    </div>

                <h1 class="espace">- Campus -</h1>

                <div class="entity-list">
                    <!-- Logo lille -->
                    <div class="entity-container-grand">
                        <a
                            class="entity-grand"
                            href="/entites/lille"
                        >
                            <img
                                src="/images/logo_campus/lille.png"
                                alt="logo_lille"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">Entités de Lille</p>
                        </div>
                    </div>
                    <!-- Logo douai -->
                    <div class="entity-container-grand">
                        <a
                            class="entity-grand"
                            href="/entites/douai"
                        >
                            <img
                                src="/images/logo_campus/douai.png"
                                alt="logo_douai"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">Entités de Douai</p>
                            {{-- faire des logos avec moins d'infos et des écritures plus garndes pour mobile ? --}}
                        </div>
                    </div>
                </div>

                <div class="description intro">
                    <p>
                        HypAIR est un site qui se veut être un complément (voir un indispensable à l'avenir) à la vie associative en ajoutant des fonctionnalités et des services qui serviront et amélioreront la vie étudiante (calendrier personnel, événement) et aussi la pérennité des comités et des associations en centralisant les informations et en les sauvegardant pour les années à venir (documentations, projets etc.).
                        Nous voulons être présents à Lille comme à Douai et disponible sur ordinateur et sur mobile.
                    </p>
                    <p>
                        Le projet HypAIR est encore à ses débuts et est donc accessible pour la première fois cette année. Cela veut donc dire que le site est encore loin d'être fini. Il y a encore beaucoup d'améliorations à apporter et de fonctionnalités que nous avons en tête.
                        Donc n'hésitez pas à nous faire des retours sur votre ressenti et sur les nouveautés que vous aimeriez voir.
                    </p>
                    <p>
                        Si vous voulez nous aider à développer notre site tout au long de l'année vous pouvez nous le faire savoir et rejoindre nos réseaux : <a href="/air">https://hypair.imt-ne.fr/air</a>
                    </p>
                </div>

                <h1 class="espace">- Services -</h1>

                <div class="entity-list">

                    <!-- Logo Calendrier -->
                    <div class="entity-container">
                        <a
                            class="entity ombre_petite"
                            href="/calendrier"
                        >
                            <div
                                class="cercle"
                                style="border-color: #e74c3c"
                            ></div>
                            <img
                                src="/images/logo_services/calendrier.png"
                                alt="logo_calendrier"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">Calendrier</p>
                        </div>
                    </div>

                    <!-- Logo CerbAIR -->
                    <div class="entity-container">
                        <a
                            class="entity"
                            href="https://cerbair.etu.imt-nord-europe.fr"
                        >
                            <div
                                class="cercle"
                                style="border-color: #1D1D1B"
                            ></div>
                            <img
                                src="/images/logo_services/cerbair-no_border.png"
                                alt="logo_cerbair"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">CerbAIR</p>
                        </div>
                    </div>

                    <!-- Logo PeerTube -->
                    <div class="entity-container">
                        <a
                            class="entity"
                            href="https://peertube.imt-ne.fr/"
                        >
                            <div
                                class="cercle"
                                style="border-color: #737373"
                            ></div>
                            <img
                                src="/images/logo_services/peertube.png"
                                alt="logo_peertube"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">PeerTube</p>
                        </div>
                    </div>
                    <!-- Logo Mastodon -->
                    {{-- <div class="entity-container">
                        <a
                            class="entity ombre_petite"
                            href="https://mastodon.social/"
                        >
                            <div
                                class="cercle"
                                style="border-color: #2791DA"
                            ></div>
                            <img
                                src="/images/logo_services/mastodon.png"
                                alt="logo_mastodon"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">Mastodon</p>
                        </div>
                    </div> --}}
                    <!-- Logo Piwigo -->
                    <div class="entity-container">
                        <a
                            class="entity"
                            href="https://photos.imt-ne.fr/"
                        >
                            <div
                                class="cercle"
                                style="border-color: #FF7700"
                            ></div>
                            <img
                                src="/images/logo_services/piwigo.png"
                                alt="logo_piwigo"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">Piwigo</p>
                        </div>
                    </div>
                    <!-- Logo GitLab -->
                    <div class="entity-container">
                        <a
                            class="entity"
                            href="https://gitlab.etu.imt-nord-europe.fr/"
                        >
                            <div
                                class="cercle"
                                style="border-color: #E34329"
                            ></div>
                            <img
                                src="/images/logo_services/gitlab.png"
                                alt="logo_gitlab"
                            />
                        </a>
                        <div class="info">
                            <h2 class="nom">GitLab</p>
                        </div>
                    </div>
                </div>

                <h1 class="espace">- Entités -</h1>

                {{-- On a décidé il y a quelques semaines de ne finalement pas mettre les valeurs de hypair dans la page d'accueil, donc on peut supprimer ce qui suit si c'est définitif --}}
                
                <!-- Values actually not displayed in the landing page -->
                <!-- <div class="values-container">
                    <div class="value">
                        <p>Une valeur de l'AIR</p>
                    </div>
                    <div class="value">
                        <p>Une deuxième valeur de l'AIR</p>
                    </div>
                </div> -->
                
                {{-- Footer vide, on ne sait pas quoi mettre dedans  --}}
                
                {{-- <div class="footer">
                    <p>Footer</p>
                    <p>Lien vers une FAQ ?</p>
                </div> --}}
            </div>

            {{-- Carrousel généré dynamiquement en prenant des logos depuis la bdd --}}
            <div class="carrousel">
                @for($i = 0; $i < 16; $i++)
                    <div @class(['bande' => true, 'shifted' => ($i % 2 == 1 )])>
                        <div class="thumbnail-container">
                            <img
                                src="/storage/images/entites/{{$entites[3*$i]}}/logos/petit"
                                alt="entity_thumbnail"
                            />
                        </div>
                        <div class="thumbnail-container">
                            <img
                                src="/storage/images/entites/{{$entites[3*$i + 1]}}/logos/petit"
                                alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                src="/storage/images/entites/{{$entites[3*$i + 2]}}/logos/petit"
                                alt="entity_thumbnail"
                                />
                            </div>
                        </div>
                        @endfor
                    </div>
                    
                    
                    {{-- Carrousel généré manuellement, pour tester sans accéder à la bdd --}}
                    {{-- ATTENTION : réduire la div qui suit ! --}}
                    {{-- <div class="carrousel">
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/mastodon.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
    
                        <div class="bande shifted">
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/piwigo.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                            <div class="thumbnail-container">
                                <img
                                    src="/images/logo_services/peertube.png"
                                    alt="entity_thumbnail"
                                />
                            </div>
                        </div>
                    </div> --}}
                </div>
@endsection
