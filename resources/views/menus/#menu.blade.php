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
	<a>
		<button id="hamburger">
			<span></span>
			<span></span>
			<span></span>
		</button>
	</a>
</div>


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

document.getElementById("hamburger").addEventListener("click", function () {
	document.getElementById("sidebar-wrapper").classList.toggle("expand")
})
</script>