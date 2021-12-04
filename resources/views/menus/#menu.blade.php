<link rel="stylesheet" href="{{ mix('css/sidenav.css') }}" type="text/css" >

<div id="sidebar-wrapper">
		<div id="sidenav" class="ombre_grande">
			<div class="sidebar-nav-icon">
				@if (null === request()->get('association_slug'))
					@yield('logo')
				@endif
			</div>
			<ul class="sidebar-nav">
				@if (request()->get('menu_perso'))
					@yield('liens')
				@else
					<a href="/accueil"><li class="icon-before-maison"><span>Accueil</span></li></a>
					<a href="/documentations"><li class="icon-before-document"><span>Documentation</span></li></a>
					<a href="/contact"><li class="icon-before-envoyer"><span>Nous contacter</span></li></a>
				@endif
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

const btn = document.querySelector("#logo_air");
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