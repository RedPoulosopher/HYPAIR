<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @vite(['resources/css/telethon.scss'])
</head>
<body style="margin: 0;">

    <div id="app">


        <div class="home">

            <!-- NAVBAR -->
            <header class="navbar">
                <a href="/" class="logo">
                    <img src="/images/telethon/logo.png" alt="Téléthon">
                    <span>ÉDITION<br>2026</span>
                </a>

                <nav>
                    <a href="#accueil">Accueil</a>
                    <a href="#evenements">Les événements</a>
                    <a href="#objectif">Notre mission</a>
                </nav>

                @if(Auth::check())
                    <a href="/deconnexion" class="nav-button">Se Déconnecter</a>
                @else
                    <a href="/login" class="nav-button">Se Connecter</a>
                @endif
            </header>


            <!-- HERO -->
            @auth
                <!-- CLASSEMENT DES ÉQUIPES -->
                <section class="leaderboard" id="classement">

                    <div class="section-title">
                        <span class="section-tag">🏆 LE CLASSEMENT</span>
                        <h2>
                            QUI SERA <span>LE GRAND GAGNANT ?</span>
                        </h2>
                        <p>
                            Chaque défi compte ! Découvre les scores des équipes
                            et suis ta progression.
                        </p>
                    </div>

                    <div class="leaderboard-container">

                        <div class="teams-ranking">

                            <div class="ranking-header">
                                <h3>🏆 Classement des équipes</h3>
                                <span>ÉDITION 2026</span>
                            </div>
                            @foreach ($teams as $index => $team)
                                <div class="team-ranking {{ $index === 0 ? 'first' : '' }}">
                                    <span class="rank-position">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <img src="/images/telethon/logo_{{ $team->uid }}.png"
                                        alt="Logo {{ $team->label }}">

                                    <div class="team-info">
                                        <strong>{{ $team->label }}</strong>
                                        <small>Équipe</small>
                                    </div>

                                    @if (auth()->user()->team_uid === $team->uid)
                                        <span class="my-team-badge">★ MON ÉQUIPE</span>
                                    @endif

                                    <span class="team-points">
                                        {{ $team->points_telethon_sum_nb_points ?? 0 }}
                                        <small>PTS</small>
                                    </span>
                                </div>
                            @endforeach

                        </div>

                        <!-- SCORE PERSONNEL -->
                        <div class="personal-score">

                            <div class="personal-score-icon">⭐</div>

                            <span class="personal-tag">TON SCORE PERSONNEL</span>

                            <h3>Bravo, champion !</h3>

                            <div class="personal-points">
                                {{ $personalPoints }} <span>PTS</span>
                            </div>

                            <div class="personal-divider"></div>

                            <div class="personal-stats">
                                <div>
                                    <strong>#{{ $personalRanking }}</strong>
                                    <span>Classement individuel</span>
                                </div>

                                <div>
                                    <strong>{{ $personalPoints }}</strong>
                                    <span>Points gagnés</span>
                                </div>
                            </div>

                            <p>
                                Continue tes efforts pour faire grimper
                                le score de ton équipe !
                            </p>

                        </div>

                </section>
            @endauth
            @if (!Auth::check())

                <section class="hero" id="accueil">

                    <div class="hero-content">
                        <span class="tag">★ ÉDITION TV THON 2026 ★</span>

                        <h1>
                            ENSEMBLE,<br>
                            ON FAIT<br>
                            <span>BOUGER</span><br>
                            LES CHOSES !
                        </h1>

                        <p>
                            Le BDH se mobilise pour le Téléthon !
                            Une semaine de défis, de jeux et d'animations
                            pour une seule mission : faire avancer la recherche.
                        </p>

                        <div class="hero-buttons">
                            <a href="/login" class="btn-primary">
                                Participer à l'aventure →
                            </a>
                            <a href="#evenements" class="btn-secondary">
                                Découvrir les activités
                            </a>
                        </div>

                        <div class="hero-bottom">
                            <span>💛 SOLIDARITÉ</span>
                            <span>★ PARTAGE</span>
                            <span>🌈 ESPOIR</span>
                        </div>
                    </div>

                    <div class="hero-decoration">
                        <div class="sun"></div>
                        <div class="hero-circle">
                            <img src="/images/telethon/logo.png" alt="Logo Téléthon">
                        </div>
                        <div class="sticker">
                            <span>100%</span>
                            <small>SOLIDAIRE !</small>
                        </div>
                        <div class="star star-one">✦</div>
                        <div class="star star-two">✳</div>
                    </div>

                </section>


                <!-- BANDEAU -->
                <div class="marquee">
                    <div class="marquee-content">
                        ★ ENSEMBLE POUR LA RECHERCHE ★
                        FAISONS LA DIFFÉRENCE ★
                        CHAQUE GESTE COMPTE ★
                        ENSEMBLE POUR LA RECHERCHE ★
                        FAISONS LA DIFFÉRENCE ★
                    </div>
                </div>
            @endif



            <!-- EVENEMENTS -->
            <section class="events" id="evenements">

                <div class="section-title">
                    <span class="section-tag">✦ LE PROGRAMME ✦</span>
                    <h2>
                        DU FUN,<br>
                        DU FUN ET <span>ENCORE DU FUN !</span>
                    </h2>
                    <p>
                        Prépare-toi ! Le comité Téléthon t'a concocté
                        un programme plein de surprises.
                    </p>
                </div>

                <div class="event-grid">

                    <article class="event-card turquoise">
                        <div class="event-icon">🎯</div>
                        <span class="event-number">01</span>
                        <h3>Défis & challenges</h3>
                        <p>
                            Relève les défis proposés et montre
                            de quoi tu es capable !
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                    <article class="event-card yellow">
                        <div class="event-icon">🎮</div>
                        <span class="event-number">02</span>
                        <h3>Jeux & animations</h3>
                        <p>
                            Viens t'amuser et partager un moment
                            convivial avec les autres participants.
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                    <article class="event-card orange">
                        <div class="event-icon">🏆</div>
                        <span class="event-number">03</span>
                        <h3>Compétitions</h3>
                        <p>
                            Défends tes couleurs et tente
                            de décrocher la victoire !
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                    <article class="event-card green">
                        <div class="event-icon">🎨</div>
                        <span class="event-number">04</span>
                        <h3>Ateliers créatifs</h3>
                        <p>
                            Exprime ta créativité à travers
                            des activités originales.
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                    <article class="event-card pink">
                        <div class="event-icon">🎤</div>
                        <span class="event-number">05</span>
                        <h3>Animations surprises</h3>
                        <p>
                            Des moments inattendus pour
                            mettre de l'ambiance !
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                    <article class="event-card turquoise">
                        <div class="event-icon">❤️</div>
                        <span class="event-number">06</span>
                        <h3>Solidarité</h3>
                        <p>
                            Chaque participation contribue
                            à soutenir la recherche.
                        </p>
                        <span class="event-label">À DÉCOUVRIR →</span>
                    </article>

                </div>

            </section>


            <!-- OBJECTIF -->
            <section class="objective" id="objectif">

                <div class="objective-decoration">✳</div>

                <div class="objective-content">
                    <span>★ PLUS QU'UN ÉVÉNEMENT ★</span>

                    <h2>
                        UN PETIT GESTE.<br>
                        <strong>UN GRAND ESPOIR.</strong>
                    </h2>

                    <p>
                        Derrière chaque activité, chaque défi et chaque
                        sourire, il y a une cause qui nous rassemble :
                        soutenir la recherche et les personnes touchées
                        par les maladies rares.
                    </p>
                </div>

                <div class="objective-illustration">
                    <div class="illustration-circle">
                        <span>💛</span>
                        <span>❤️</span>
                        <span>🩵</span>
                    </div>
                    <div class="illustration-text">
                        TOUS ENSEMBLE !
                    </div>
                </div>

            </section>


            <!-- CTA -->
            @if (!Auth::check())
                <section class="join">
                    <span>✦ ALORS, TU NOUS REJOINS ? ✦</span>
                    <h2>LA SOLIDARITÉ,<br>ÇA SE VIT ENSEMBLE !</h2>
                    <p>
                        Connecte-toi pour découvrir les activités
                        et participer à cette belle aventure.
                    </p>
                    <a href="/login" class="btn-dark">
                        Je participe →
                    </a>
                </section>
            @endif



            <!-- FOOTER -->
            <footer>
                <div class="footer-top">
                    <div class="footer-logo">
                        <img src="/images/telethon/logo.png" alt="Téléthon">
                        <div>
                            <strong>BDH × TÉLÉTHON</strong>
                            <p>Unis par la solidarité, motivés par l'espoir.</p>
                        </div>
                    </div>

                    <a href="#accueil" class="back-top">↑ RETOUR EN HAUT</a>
                </div>

                <div class="footer-bottom">
                    <span>© 2026 BDH - Tous droits réservés</span>
                    <span>FAIT AVEC ❤️ POUR LE TÉLÉTHON</span>
                </div>
            </footer>

        </div>

    </div>

</body>
</html>
