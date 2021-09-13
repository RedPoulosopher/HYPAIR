<script>
function set_theme(theme){
	document.body.classList.value="";
	if (theme=="dark") {
		document.body.classList.add("dark-theme");
		set_var("sombre");
	} else {
		document.body.classList.add("light-theme");
		set_var("clair");
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
</script>