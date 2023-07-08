<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Accueil - HypAIR</title>
        <link
            rel="stylesheet"
            href="css/accueil.css"
            type="text/css"
        />
    </head>
    
@include('layouts.theme')

    <body>
        <!-- Barre de navigation -->
        <x-navbar/>

        <!-- Contenu de la page -->
        <div id="content">
            
            <!-- Contenu principal de la page -->
            <div id="main-content">
                <h1>Outils</h1>

                <div class="services-wrapper">
                    
                    <div class="service-container">
                        <a href="/calendrier" class="service-ombre-petite">
                            <div class="cercle" style="border-color: #e74c3c"></div>
                            <img src="/images/logo_services/calendrier.png" alt="logo_calendrier" height="80">
                        </a>
                        <p>Calendrier</p>
                    </div>

                    <div class="service-container">
                        <a href="https://photos.imt-ne.fr" class="service-ombre-petite" target="_blank">
                            <div class="cercle" style="border-color: #e74c3c"></div>
                            <img src="/images/logo_services/piwigo.png" alt="logo_piwigo" height="80">
                        </a>
                        <p>Photos</p>
                    </div>

                    <div class="service-container">
                        <a href="https://peertube.imt-ne.fr" class="service-ombre-petite" target="_blank">
                            <div class="cercle" style="border-color: #e74c3c"></div>
                            <img src="/images/logo_services/peertube.png" alt="logo_peertube" height="80">
                        </a>
                        <p>Vidéos - PeerTube</p>
                    </div>

                    <div class="service-container">
                        <a href="https://gitlab.etu.imt-ne.fr" class="service-ombre-petite" target="_blank">
                            <div class="cercle" style="border-color: #e74c3c"></div>
                            <img src="/images/logo_services/gitlab.png" alt="logo_gitlab" height="80">
                        </a>
                        <p>GitLab</p>
                    </div>

                </div>

                <h1>Actualités</h1>
    
                <div class="article-wrapper">
                    <x-event title="Intro à Git" author="l'AIR" />
                    <x-event title="Shotgun Allô bouffe" author="BDS" />
                </div>
    
            </div>
    
            <!-- Side bar : planning de la semaine -->
            <div id="side-bar">
    
                <div id="calendrier">
                    <h1>Cette semaine</h1>
    
                    <div class="day-card">
                        <h5>Lundi</h5>
                        <p>Lorem Ipsum</p>
                    </div>
    
                    <div class="day-card">
                        <h5>Mardi</h5>
                        <p>Lorem Ipsum</p>
                    </div>
    
                    <div class="day-card">
                        <h5>Mercredi</h5>
                        <p>Lorem Ipsum</p>
                    </div>
    
                    <div class="day-card">
                        <h5>Jeudi</h5>
                        <p>Lorem Ipsum</p>
                    </div>

                    <div class="day-card">
                        <h5>Vendredi</h5>
                        <p>Lorem Ipsum</p>
                    </div>   
                    
                    <div class="day-card">
                        <h5>Samedi</h5>
                        <p>Lorem Ipsum</p>
                    </div>  

                    <div class="day-card">
                        <h5>Dimanche</h5>
                        <p>Lorem Ipsum</p>
                    </div>  
                </div>
            </div>
        </div>
    
        <footer>
            Fait avec amour par l’AIR - Tous droits réservés
        </footer>
    </body>
    
</html>
