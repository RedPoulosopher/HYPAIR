<!-- Component de la barre de navigation principale (celle du haut) -->

<nav id="navbar">

  <a href="/" id="logo">
      <img src="/images/logo_air.png" alt="Une création originale de l'AIR">
      <h1>Hyp<span>AIR</span></h1>
  </a>
  
  <ul id="links">
      <x-toggle-theme-btn/>
      <li class="menu-button"><a href="/">Accueil</a></li>
      <li class="menu-button"><a href="/calendrier">Calendrier</a></li>
      <li class="menu-button"><a href="/entites">Associations</a></li>
      <li class="menu-button"><a href="/mes-entites">Gestion</a></li>
      <li class="menu-button"><a href="/contact">Contact</a></li>

      @if($isConnected)
        <div id="lien_profil">
          <a href="/home">
            <img id="photo_lien_profil" src="{{$user->chemin_photo_de_profil}}" title="{{$user->prenom}} {{$user->nom}}"/>
          </a>
        </div>
      @else
        <li class="menu-button connect-button"><a href="/home">Se connecter</a></li>
      @endif
  </ul>


</nav>