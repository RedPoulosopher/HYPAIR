<div id="menu_lateral">
	<div class="ombre_grande">
		<div class="logotype">
			@hasSection('logo')
				@yield('logo')
			@else
				<img class="arrondi" src="{{session("entite_logo_petit")}}" alt="logo"/>
			@endif
		</div>
		<ul class="navigation">
			@yield('liens')
			@if (session('gerer_entite'))
				<a href="gestion"><li><span>Gestion</span></li></a>
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
	localStorage.setItem("menu_ouvert", el_sidebar_wrapper.classList.toggle("menu_affiche"))
})

if(localStorage.getItem("menu_ouvert")=="true" && window.matchMedia("(min-width: 768px)").matches){
	el_sidebar_wrapper.classList.toggle("menu_affiche")
}
</script>
