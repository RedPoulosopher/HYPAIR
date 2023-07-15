<!-- Component de la barre de navigation principale (celle du haut) -->

<nav id="navbar">

  <div id="logo">
    <a href="/" id="logo-img">
        <img src="images/logo_air.png" alt="Une création originale de l'AIR">
    </a>
    <a href="/" id="logo-text">
      <h1>Hyp<span>AIR</span></h1>
    </a>
  </div>

  <div id="nav-content">
    <x-toggle-theme-btn/>
    <ul id="links">
        <li class="menu-button"><a href="/">Accueil</a></li>
        <li class="menu-button"><a href="/calendrier">Calendrier</a></li>
        <li class="menu-button"><a href="/entites">Associations</a></li>
        <li class="menu-button"><a href="/mes-entites">Gestion</a></li>
        <li class="menu-button"><a href="/contact">Contact</a></li>
  
        @if($isConnected)
          <li id="profile-button" class="menu-button">
            <a href="/home">
              <img id="photo_lien_profil" src="{{$user->chemin_photo_de_profil}}"/>
              <p>{{$user->prenom}} {{$user->nom}}</p>
            </a>
          </li>
        @else
          <li id="connect-button" class="menu-button"><a href="/home">Se connecter</a></li>
        @endif
    </ul>
    <div id="services">
      <a href="/calendrier" class="service">
        <img src="/images/logo_services/calendrier.png" alt="logo_calendrier" id="service-calendrier">
        <p>Calendrier</p>
      </a>
      <a href="https://photos.imt-ne.fr" class="service" target="_blank">
        <img src="/images/logo_services/piwigo.png" alt="logo_piwigo" id="service-piwigo">
        <p>Photos</p>
      </a>
      <a href="https://peertube.imt-ne.fr" class="service" target="_blank">
        <img src="/images/logo_services/peertube.png" alt="logo_peertube" id="service-peertube">
        <p>Vidéos</p>
      </a>
      <a href="https://gitlab.etu.imt-nord-europe.fr" class="service" target="_blank">
        <img src="/images/logo_services/gitlab.png" alt="logo_gitlab" id="service-gitlab">
        <p>GitLab</p>
      </a>
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