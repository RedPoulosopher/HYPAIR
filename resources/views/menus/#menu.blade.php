<div id="sidebar-wrapper">
		<div id="sidenav" class="ombre_grande">
			<div class="sidebar-nav-icon">
				@yield('logo')
			</div>
			<ul class="sidebar-nav">
				@yield('liens')
				{{-- <a href="#"><li class="icon-before-profil sidebar-nav-bottom"><span>Se déconnecter</span></li></a> --}}
			</ul>
		</div>
		<a href="#">
			<button id="hamburger">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</a>
	</div>
</div>


<script>
const btn = document.querySelector("#logo_menu");
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