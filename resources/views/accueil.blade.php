<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Accueil - HypAIR</title>
        <link
            rel="stylesheet"
            href="/css/accueil.css"
            type="text/css"
        />
    </head>

    <body class="dark-theme">
        <div id="wrapper">
            <div id="contenu" class="grand">
                <h1 class="titre-page">--- HypAIR ---</h1>

                <div class="header">
                    <div class="logo">
                        <img
                            src="/images/logo_air_1.png"
                            alt="logo_hypair"
                        />
                    </div>
                </div>

                <div class="entity-list grille-enfants">
                    <!-- Logo lille -->
                    <div class="entity-container-grand">
                        <a
                            class="entity-grand ombre_petite"
                            href="/entites/lille"
                        >
                            <img
                                src="/images/logo_temp/lille.png"
                                alt="logo_lille"
                            />
                        </a>
                        <div class="info">
                            <p class="nom">Entités de Lille</p>
                        </div>
                    </div>
                    <!-- Logo douai -->
                    <div class="entity-container-grand">
                        <a
                            class="entity-grand ombre_petite"
                            href="/entites/douai"
                        >
                            <img
                                src="/images/logo_temp/douai.png"
                                alt="logo_douai"
                            />
                        </a>
                        <div class="info">
                            <p class="nom">Entités de Douai</p>
                        </div>
                    </div>
                </div>

                <div class="intro texte_grand">
                    <p>Phrases pour présenter le projet</p>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing
                        elit. Tempora eum animi sint qui aspernatur obcaecati
                        nostrum pariatur! Quia similique quis atque doloremque
                        numquam veritatis, possimus quod nesciunt vel voluptatem
                        voluptas sit nostrum incidunt sunt minima sequi aut?
                        Corrupti tempore debitis nostrum nisi corporis
                        voluptatibus placeat assumenda explicabo eum tempora
                        suscipit, error accusamus, dolor, vero soluta quod
                        deserunt nulla quae dolorem nesciunt atque magnam.
                        Obcaecati porro totam, exercitationem sapiente tenetur
                        repellendus?
                    </p>
                </div>

                <h1 class="espace">- Services -</h1>

                <div class="entity-list grille-enfants">
                    <!-- Logo cerbair -->
                    <div class="entity-container">
                        <a
                            class="entity ombre_petite"
                            href="https://cerbair.etu.imt-nord-europe.fr"
                        >
                            <div
                                class="cercle"
                                style="border-color: #A00914"
                            ></div>
                            <img
                                src="/images/logo_services/cerbair.svg"
                                alt="logo_cerbair"
                            />
                        </a>
                        <div class="info">
                            <p class="nom">CerbAIR</p>
                        </div>
                    </div>
                    <!-- Logo PeerTube -->
                    <div class="entity-container">
                        <a
                            class="entity ombre_petite"
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
                            <p class="nom">PeerTube</p>
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
                            <p class="nom">Mastodon</p>
                        </div>
                    </div> --}}
                    <!-- Logo Piwigo -->
                    <div class="entity-container">
                        <a
                            class="entity ombre_petite"
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
                            <p class="nom">Piwigo</p>
                        </div>
                    </div>
                    <!-- Logo gitlab -->
                    <div class="entity-container">
                        <a
                            class="entity ombre_petite"
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
                            <p class="nom">GitLab</p>
                        </div>
                    </div>
                </div>

                <h1 class="espace">- Entités -</h1>

                {{-- Début carrousel (je n'ai pu tester comme je n'ai pas accès aux images, il manque peut etre une ligne pour accéder à la bdd) --}}

                {{-- <div class="carrousel">
                    @php
                        $liste_logos = array();
                        foreach ($bureaux as $bureau) {
                            foreach ($comites_clubs_dependants[$bureau->ratachement->value] as $comite_club) {
                                array_push($liste_logos, $comite_club->logo_url("petit"))
                            }
                        }
                        // extrait les 48 premiers logos de la liste après avoir mélangé
                        shuffle($liste_logos)
                        $logos_carrousel = array_slice($liste_logos, 0, 48)
                        // pour chaque colonne
                        for ($col = 0; $col < 16; $col++) {
                            if ($col % 2 == 0) {
                                echo '<div class="bande">';
                            } else {
                                echo '<div class="bande shifted">';
                            }
                            for ($i = 0; $i < 4; $i++ ) {
                                echo '<div class="thumbnail-container">';
                                    echo '<img src="$logos_carrousel[($col * 4) + $i]" alt="entity_thumbnail" />'
                                echo '</div>';
                            }
                            echo '</div>'

                        }
                    @endphp
                </div> --}}

                {{-- Fin du carrousel généré dynamiquement --}}

                {{-- Attention : REDUIRE LA DIV CARROUSEL (qui fait des centaines de lignes) --}}
                {{-- Elle est là juste pour avoir un modèle d ela structure à avoir (à générer dynamiquement en allant chercher les logos des entités) --}}

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
        </div>
    </body>
</html>
