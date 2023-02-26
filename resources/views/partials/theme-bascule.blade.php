<div id="bascule-mode">
  <h6 class="label-sombre">Sombre</h6>
  <div id="bascule-theme"></div>
  <h6 class="label-clair">Clair</h6>
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
</script>