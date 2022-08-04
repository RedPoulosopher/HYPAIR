@extends('layouts.vide')

@section('titre', 'Home')

@section('content')


<style>

#profil {
  padding:20px;
  margin-top:20px;
  height: auto;
  display:flex;
  flex-direction:row;
  flex-wrap:wrap;
  row-gap:40px;
  column-gap: 30px;
}

#photo_profil {
	max-width:260px;
	max-height:260px;
  margin-left: auto;
  margin-right: auto;
}
#photo_profil img {
	width:100%;
	border-radius:300px;
}

#info_profil {
  display:flex;
  flex-direction:column;
  flex-grow:4;
  flex-basis:40ch;
  row-gap:20px;
}

#ligne_prenoms {
  width:100%;
  display:flex;
  flex-direction:row;
  justify-content:space-between;
  align-items:center;
}

#prenoms {
  display:flex;
  flex-direction:row;
  align-items:center;
  flex-wrap:wrap;
  gap:5px;
}

#prenoms h2 {
  margin-top:0px;
  margin-bottom:0px;
}

#prenoms .pronoms {
  color:grey;
  font-weight:normal;
}

#reglages {
  font-size:1.5em;
  transform: rotate(0deg);
  transition-duration: 0.7s;
}

#reglages:hover {
  color: var(--couleur_police_secondaire);
  transform: rotate(60deg);
  transition-duration: 0.7s;
}

#menu_meatballs {
    /* display:none; */
    position: absolute;
    z-index:1;
    border-radius:15px;
    background:var(--gris_1);
    padding-inline-start: 0px;
}
#menu_meatballs li {
    display:block;
    width:100%;
    list-style-type: none;
}
#menu_meatballs li a {
    padding:10px 20px;
    display: inline-block;
}

#menu_meatballs li #menu_deconnexion {
  color: var(--couleur_accentuation);
}

#menu_meatballs li a:hover {
    color: var(--couleur_police_secondaire);
}

#menu_meatballs li #menu_deconnexion:hover {
  color: var(--couleur_police_secondaire);
}

#reglages:hover #menu_meatballs {
  display:block;
}

#bio {
	max-width: 80ch;
	text-align: justify;
	overflow-wrap: break-word;
}

#boutons_selections_categorie {
  width: 100%;
  display:flex;
  flex-direction:row;
  flex-wrap:wrap;
  align-items:center;
  justify-content:space-around;
  gap:10px;
}

.reseaux_sociaux {
  margin-top: 12px;
	gap: 12px;
}
.reseaux_sociaux > a {
	padding: 10px 18px;
	border-radius: 50px;
}
</style>

<div id="contenu" class="moyen">
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
          {{$user->bio}}
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
