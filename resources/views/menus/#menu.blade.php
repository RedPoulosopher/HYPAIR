<div id="menu_lateral">
	<div class="ombre_grande">
		<div class="logotype">
			{{-- {{ Breadcrumbs::render() }} --}}
			<a href="/entites?defaut">
				@hasSection('logo')
					@yield('logo')
				@else
					<img class="arrondi" src="{{session("entite_logo_petit")}}" alt="logo"/>
				@endif
			</a>
		</div>
		<ul class="navigation">
			@yield('liens')
			@if (session('gerer_entite'))
				<a href="{{ session('entite_lien') }}/entite/gestion"><li><span>Gestion</span></li></a>
			@endif
		</ul>
		<div id="bascule-mode">
			<h6 class="label-sombre">Sombre</h6>
			<div id="bascule-theme"></div>
			<h6 class="label-clair">Clair</h6>
		</div>
	</div>
</div>
<button id="hamburger">
	<span></span>
	<span></span>
	<span></span>
</button>


@php
use App\Services\GestionPhotoDeProfil;
if (Auth::check()) {
    $user = Auth::user();
    $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
}
@endphp

@if (Auth::check())
<div id="lien_profil"><a href="/home"><img id="photo_lien_profil" src="{{$user->chemin_photo_de_profil}}" title="{{$user->prenom}} {{$user->prenom}}"/></a></div>
@else
<a href="/home" id="bouton_se_connecter" class="bouton primaire">Se connecter</a>
@endif


<script>
const btn = document.querySelector("#bascule-theme");
btn.addEventListener("click", function () {
	ancien_theme = localStorage.getItem("theme");
	if(ancien_theme=="dark"){
	theme="light"
	}else{
	theme="dark"
	}
	set_theme(theme)
	localStorage.setItem("theme", theme);
});

el_sidebar_wrapper = document.getElementById("menu_lateral")
document.getElementById("hamburger").addEventListener("click", function () {
	bascule_affichage_menu()
})

function bascule_affichage_menu(){
	el_wrapper = document.getElementById("wrapper")

	est_affiche = el_sidebar_wrapper.classList.toggle("menu_affiche")
	localStorage.setItem("menu_ouvert", est_affiche)

	if(est_affiche){
		el_wrapper.addEventListener('click', bascule_affichage_menu)
	} else {
		el_wrapper.removeEventListener('click', bascule_affichage_menu)
	}
}

if(localStorage.getItem("menu_ouvert")=="true" && window.matchMedia("(min-width: 768px)").matches){
	el_sidebar_wrapper.classList.toggle("menu_affiche")
}
</script>
