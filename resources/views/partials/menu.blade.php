<div id="sidebar-wrapper">
		<div id="sidenav" class="ombre_grande">
			<div class="sidebar-nav-icon">
				<img id="logo_air" src="/images/logo_air.png" width="120px" alt="logo de l'AIR"/>
				<span>AIR</span>
			</div>
			<ul class="sidebar-nav">
				<a href="/accueil"><li class="icon-before-maison"><span>Accueil</span></li></a>
				<a href="/documentations"><li class="icon-before-document"><span>Documentation</span></li></a>
				<a href="/contact"><li class="icon-before-envoyer"><span>Nous contacter</span></li></a>
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
function set_theme(theme){
		document.body.classList.value="";
		if (theme=="dark") {
		document.body.classList.add("dark-theme");
		} else {
		document.body.classList.add("light-theme");
		}
}

const btn = document.querySelector("#logo_air");

currentTheme = localStorage.getItem("theme");
if (currentTheme == null){
		if(window.matchMedia("(prefers-color-scheme: dark)").matches){
		currentTheme = "dark"
		} else {
		currentTheme = "light"
		}
		localStorage.setItem("theme", currentTheme);
}
set_theme(currentTheme)

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


$(document).ready(function(){
		$("#hamburger").click(function(e){
		e.preventDefault();
		$("#sidebar-wrapper").toggleClass("expand");
		});
});

</script>