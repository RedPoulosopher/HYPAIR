@extends('layouts.app-without-sidebar')

@section('titre', 'Home')

@pushonce('styles')
<link rel="stylesheet" href="css/home.css" type="text/css" />
@endpushonce

@section('content')

<div id="contenu" class="moyen">
  <a href="/" class="bouton secondaire">< Retour</a>
	<div id="profil">
    <div id="photo_profil">
      <img src="{{$user->chemin_photo_de_profil}}" alt="Votre photo de profil"/>
    </div>
      <div id="info_profil">
        <div id="ligne_prenoms">
          <div id="prenoms">
            <h2>{{$user->prenom}} {{$user->nom}}</h2>
            @if ($user->pronom !== '')
              <h2 class="pronoms">•</h2>
              <h2 class="pronoms">{{$user->pronom}}</h2>
            @endif
          </div>
            <a id="reglages" tabindex="1" class="icon-setting-2" title="Réglages" onclick="javascript:menu_meatballs()"></a>
        </div>
        <div id="bio">
          {!! nl2br(e($user->bio)) !!}
        </div>
        <div class="reseaux_sociaux grille-enfants">
          @foreach ($reseaux_sociaux as $reseau_social)
    				<a target="_blank" class="ombre_petite" tabindex="3" href="{{ $reseau_social->liste->pre_url . $reseau_social->cle }}" style="background-color:{{ $reseau_social->liste->couleur }}; color:{{ $reseau_social->liste->couleur_police }};">
    					{{ $reseau_social->liste->nom }}
    				</a>
    			@endforeach
      </div>
    </div>
    <ul id="menu_meatballs" class="ombre_grande">
        <li><a id="menu_modifier_photo_profil" tabindex="2" href="/editer_photo_profil">Modifier la photo de profil</a></li>
        <li><a id="menu_modifier_info" tabindex="2" href="/editer_infos_profil">Modifier les infos</a></li>
        <li><a id="menu_modifier_reseaux" tabindex="2" href="/editer_reseaux_profil">Gérer les réseaux sociaux</a></li>
        <li><a id="menu_deconnexion" tabindex="2" href="/deconnexion">Se déconnecter</a></li>
    </ul>
  </div>
</div>
@endsection

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
  taille_x_menu_meatballs = el_menu_meatballs.getBoundingClientRect().width;
  reglages = document.getElementById("reglages");
  taille_x_meatballs = reglages.getBoundingClientRect().width;
  el_menu_meatballs.style.display = "none";
  /*accessibilité*/
  reglages.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        reglages.click();
    }
  });
};

/*meatball*/
/*merci marc pour le menu meatball, il est trop bien*/
function menu_meatballs(){
    if (ouvert) {
      el_menu_meatballs.style.display = "none";
      ouvert = false;
    } else {
      el_menu_meatballs.style.display = "block";
      ouvert = true
    }

    left = reglages.getBoundingClientRect().x;
    topp = reglages.getBoundingClientRect().y;
    height = reglages.getBoundingClientRect().height;

    el_menu_meatballs.style.top = topp + 18 + document.documentElement.scrollTop + "px";
    el_menu_meatballs.style.left = left - taille_x_menu_meatballs + taille_x_meatballs + "px";
};
</script>
