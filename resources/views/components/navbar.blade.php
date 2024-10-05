{{-- Component de la barre de navigation principale (celle du haut) --}}

<nav id="navbar" {{-- class="campagnes" --}}>

    <div id="logo">
        <a href="/" id="logo-img">
            <img src="{{ Vite::Image('logo_air.png') }}" alt="Une création originale de l'AIR">
        </a>
        <a href="/" id="logo-text">
            <h1>Hyp<span>AIR</span></h1>

        </a>
    </div>

    <div id="nav-content">
        <x-toggle-theme-btn />
        <ul id="links">
            <li class="menu-button {{ request()->is('/') ? 'active' : '' }}"><a href="/">Accueil</a></li>
            <li class="menu-button {{ request()->is('calendrier') ? 'active' : '' }}"><a href="/calendrier">Calendrier</a></li>
            <li class="menu-button {{ request()->is('entites*') ? 'active' : '' }}"><a href="/entites">Associations</a></li>

            {{-- A afficher que pendant les campagnes --}}
            {{-- <li class="menu-button {{ request()->is('campagnes') ? 'active' : '' }}"><a href="/campagnes">Campagnes</a></li> --}}


            <li class="menu-button {{ request()->is('contact') ? 'active' : '' }}"><a href="/contact">Contact</a></li>

            @if (Auth::check())
                <li id="profile-button" class="menu-button">
                    <a href="/home">
                        <p>Profil</p>
                        <img id="photo_lien_profil" src="{{ Auth::user()->chemin_photo_de_profil }}" />
                    </a>
                </li>
            @else
                <li id="connect-button" class="menu-button"><a href="/connexion">Se connecter</a></li>
            @endif
        </ul>
        <div id="services">
            @if (Auth::check() &&
                    Auth::user()->campus->pluck('label')->contains('douai'))
                <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800
                    logo="{{ Vite::Image('piwigo.png') }}">
                </x-service>
            @endif
            
            <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272
                logo="{{ Vite::Image('peertube.png') }}"></x-service>
            {{-- <x-service nom="AIRplace" destination='https://airplace.etu.imt-nord-europe.fr' color=#cc3345
                logo="{{ Vite::Image('airplace.png') }}"></x-service> --}}

            <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                logo="{{ Vite::Image('gitlab.png') }}"></x-service>
            <x-service nom="Tutoriels HypAIR"
                destination='https://partage.imt.fr'
                color=#4c4372 logo="{{ Vite::Image('tutorial.png') }}">
            </x-service>
        </div>
    </div>

    <div id="hamburger-toggle">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
    </div>

    <script>
        var menu = document.getElementById('hamburger-toggle');
        var navContent = document.getElementById('nav-content');
        var hamburgerMenuOpened = false;

        menu.onclick = () => {
            hamburgerMenuOpened = !hamburgerMenuOpened;
            menu.classList.toggle("active");
            navContent.classList.toggle("active");

        }
    </script>
</nav>
