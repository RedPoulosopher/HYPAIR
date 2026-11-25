<script setup>
    const props = defineProps({
        bladeData: {
            type: Object,
            default: () => ({})
        }
    });
    const bladeData = props.bladeData
    console.log(bladeData)
</script>
<template>
    <div class="home">

        <!-- NAVBAR -->
        <header class="navbar">
            <a href="/" class="logo">
                <img src="http://127.0.0.1:8000/images/telethon/logo.png" alt="Téléthon">
                <span>ÉDITION<br>2026</span>
            </a>

            <nav>
                <a href="#accueil">Accueil</a>
                <a href="#evenements">Les événements</a>
                <a href="#objectif">Notre mission</a>
            </nav>

            <div></div>
        </header>


        <!-- HERO -->
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
                    <img src="http://127.0.0.1:8000/images/telethon/logo.png" alt="Logo Téléthon">
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


        <!-- FOOTER -->
        <footer>
            <div class="footer-top">
                <div class="footer-logo">
                    <img src="http://127.0.0.1:8000/images/telethon/logo.png" alt="Téléthon">
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
</template>


