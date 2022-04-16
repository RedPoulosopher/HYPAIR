<div id="sidebar-wrapper">
	<div id="sidenav" class="ombre_grande">
		<div class="sidebar-nav-icon">
			@hasSection('logo')
				@yield('logo')
			@else
				<img id="logo_menu" class="arrondi" src="{{session("entite_logo_petit")}}" alt="logo"/>
			@endif
		</div>
		<ul class="sidebar-nav">
			@yield('liens')
			@if (session('gerer_entite'))
				<a href="gestion"><li><span>Gestion</span></li></a>
			@endif
		</ul>
	</div>
	<div id="bascule-mode">
		<h6 class="label-sombre">Sombre</h6>
		<div id="bascule-theme"></div>
		<h6 class="label-clair">Clair</h6>
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

el_sidebar_wrapper = document.getElementById("sidebar-wrapper")
document.getElementById("hamburger").addEventListener("click", function () {
	localStorage.setItem("menu_ouvert", el_sidebar_wrapper.classList.toggle("expand"))
})

if(localStorage.getItem("menu_ouvert")=="true" && window.matchMedia("(min-width: 768px)").matches){
	el_sidebar_wrapper.classList.toggle("expand")
}
</script>
