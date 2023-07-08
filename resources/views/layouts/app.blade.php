<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>@yield('title', 'Site Web') - HypAIR</title>
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
        @yield('content')
    
            <!-- Side bar : planning de la semaine -->
            <aside id="side-bar">
    
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
            </aside>
        </div>
        
        <footer>
            Fait avec amour par l’AIR - Tous droits réservés
        </footer>
    </body>
    
</html>
