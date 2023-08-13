@extends('layouts.app-without-sidebar')

@section('titre', 'Home')

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/espace_utilisateur/home.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ mix('/css/espace_utilisateur/mes_entites.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ mix('/css/components/reseau-social.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ mix('/css/components/entite.css') }}" type="text/css" />
@endpushonce

@section('content')

<div id="main-content" class="moyen">
  <section>
    <h1>Mon profil</h1>
    <div id="profil" class="card">
      <div id="photo_profil">
        <img src="{{$user->chemin_photo_de_profil}}" alt="Votre photo de profil"/>
      </div>
      <div id="info_profil">
        <div id="ligne_prenoms">
          <div id="prenoms">
            <h2>{{$user->prenom}} {{$user->nom}}</h2>
            @if ($user->pronom !== '')
              <h3 class="pronoms">•</h3>
              <h3 class="pronoms">{{$user->pronom}}</h3>
            @endif
          </div>
          <a id="reglages" tabindex="1" class="icon-setting-2" title="Réglages" onclick="javascript:menu_meatballs()"></a>
        </div>
        @if($user->bio)
          <div id="bio">
            {!! nl2br(e($user->bio)) !!}
          </div>
        @endif
        @if(count($reseaux_sociaux) > 0)
          <div class="reseaux_sociaux">
            @foreach ($reseaux_sociaux as $reseau_social)
              <x-reseau-social :reseau="$reseau_social" />
            @endforeach
          </div>
        @endif
      </div>
      <ul id="menu_meatballs" class="ombre_grande">
          <li><a id="menu_modifier_photo_profil" tabindex="2" href="/editer_photo_profil">Modifier la photo de profil</a></li>
          <li><a id="menu_modifier_info" tabindex="2" href="/editer_infos_profil">Modifier les infos</a></li>
          <li><a id="menu_modifier_reseaux" tabindex="2" href="/editer_reseaux_profil">Gérer les réseaux sociaux</a></li>
          <li><a id="menu_deconnexion" tabindex="2" href="/deconnexion">Se déconnecter</a></li>
      </ul>
    </div>
  </section>


  @if(count($entites_admin) > 0 || count($entites_membre) > 0)
    <section>
      <h1>Mes entités</h1>

      @if(count($entites_admin)>0)
        <h2>Admin</h2>        
        <div class="entites-wrapper">
                @foreach ($entites_admin as $entite)
                    <x-entite :asso="$entite" :destination="$entite->lien_gestion_relatif()" />
                @endforeach
        </div>
      @endif

      @if(count($entites_membre)>0)
        <h2>Membre</h2>
        <div class="entites-wrapper">
                @foreach ($entites_membre as $entite)
                    <x-entite :asso="$entite" :destination="$entite->lien_relatif()" />
                @endforeach
        </div>
      @endif
    </section>
  @endif

</div>

<script>
  
  /*meatball*/
  var ouvert = false;
  var el_menu_meatballs;
  var taille_x_menu_meatballs;
  var taille_x_meatballs;
  /*accessibilité*/
  var reglages;
  
  window.onload = init;
  
  function init() {
    /*meatball*/
    el_menu_meatballs = document.getElementById("menu_meatballs");
    el_menu_meatballs.style.display = "none";

    /*accessibilité*/
    reglages = document.getElementById("reglages");
    reglages.addEventListener("keyup", function(event) {
      event.preventDefault();
      if (event.keyCode === 13) {//Si appuie sur Entrée
        reglages.click();
      }
    });

    window.addEventListener("keyup", function(event) {
      event.preventDefault();
      if (ouvert && event.keyCode === 27) {//Si appui sur Echap et menu ouvert
        reglages.click();
      }
    });
  };
  
  /*meatball*/
function menu_meatballs(){
  console.log("click")
  if (ouvert) {
    el_menu_meatballs.style.display = "none";
    ouvert = false;
  } else {
    el_menu_meatballs.style.display = "block";
    ouvert = true
  }
};
</script>

@endsection