{{-- Component de la barre de navigation principale (celle du haut) --}}

<nav id="navbar">

    <div id="logo">
        <a href="/" id="logo-img">
            <img src="{{ mix('/images/logo_air.png') }}" alt="Une création originale de l'AIR">
        </a>
        <a href="/" id="logo-text">
            <h1>Hyp<span>AIR</span></h1>

        </a>
    </div>

    <div id="nav-content">
        <x-toggle-theme-btn />
        <ul id="links">
            <li class="menu-button {{ request()->is('/') ? 'active' : '' }}"><a href="/">Accueil</a></li>
            <li class="menu-button {{ request()->is('calendrier') ? 'active' : '' }}"><a
                    href="/calendrier">Calendrier</a></li>
            <li class="menu-button {{ request()->is('entites*') ? 'active' : '' }}"><a href="/entites">Associations</a>
            </li>
            {{-- <li
                class="menu-button {{ (request()->is('mes-entites') ? 'active' : '') . (request()->is('*entite/*') ? 'active' : '') }}">
                <a href="/mes-entites">Gestion</a></li> --}}
            <li class="menu-button {{ request()->is('contact') ? 'active' : '' }}"><a href="/contact">Contact</a></li>

            @if ($isConnected)
                <li id="profile-button" class="menu-button">
                    <a href="/home">
                        <p>Profil</p>
                        <img id="photo_lien_profil" src="{{ $user->chemin_photo_de_profil }}" />
                    </a>
                </li>
            @else
                <li id="connect-button" class="menu-button"><a href="/home">Se connecter</a></li>
            @endif
        </ul>
        <div id="services">
            <x-service nom="Piwigo" destination='https://photos.imt-ne.fr' color=#FF7800
                logo="{{ mix('/images/piwigo.png') }}">
            </x-service>
            <x-service nom="PeerTube" destination='https://peertube.imt-ne.fr' color=#727272
                logo="{{ mix('/images/peertube.png') }}"></x-service>
            <x-service nom="GitLab" destination='https://gitlab.etu.imt-nord-europe.fr' color=#E24329
                logo="{{ mix('/images/gitlab.png') }}"></x-service>
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
