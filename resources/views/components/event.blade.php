<!-- COMPONENT des évènements de la page d'accueil -->

<div id="event">

  <div id="header">

      <img class="thumbnail" src="images/logo-air-rond-test.png" alt="AIR">

      <div class="details">
          <div id="main-title">
              <h2>Introduction a Git</h2>
              <p>•</p>
              <p>Poste par l'AIR</p>
          </div>
      

          <div class="tags">
              <div class="tag">
                  <p>Event</p>
              </div>
              <div class="tag">
                  <p>Event</p>
              </div>
              <div class="tag">
                  <p>Event</p>
              </div>
              <div class="tag">
                  <p>Event</p>
              </div>
              <div class="tag">
                  <p>Event</p>
              </div>
          </div>

      </div>

      <div id="release-date">
            <!-- Icône de calendrier -->
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="20" height="20" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_7_161" transform="scale(0.0104167)"/>
                </pattern>
                <image id="image0_7_161" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAB90lEQVR4nO3dTU4UYRiF0Z60a1FcqoIYV4MuQ12IwAySayrWhISyR3yn8tU9G+A+9fI36jqdqqqq3kguOGF73zd9YHa+b/rA7Hzf9IHZ+b7pA7PzfdMHZuf7pg/MzvdNH5id77soycckX5L8SvKY+T2urTdJruSDf5fkW5LnHNdzkq9JzuLh/9D1O/J96BHW7/x66Xbk7/wj/9rZ8pTkw4gD3G5OqOsRB/jd57zp54gDPGx//cO7H3GA+o8eAOsBsB4A6wGwHgDrAbAeAOsBsB4A6wGwHuDoBzhNLrqfD8B4Px+A8X4+AOP9fADG+/kAjPfzARjv5wMw3s8HYLyfD8B4Px+A8X4+AOP9fADG+/kAjPfzARjv5wMw3s8HYLyfD8B4Px+A8X4+AOP9fADG+/kAjPfzARjv5wMw3s8HYLyfD8B4Px+A8X4+AOP9fADG+/kAjPfzARjv5wMw3s8HYLyfD8B4Px+A8X4+AOP9fADG+/kAjPfzARjv5wMw3s8HYLyfD8B4Px+A8X4+AOP9Se4vjTiwPyMOsLy8oOBHFy9vjqjXfRpxgKt+fP3mx9e/f/MDrEdYXttRL90MefjrAc7razvqnzvxHpnz+jKH5UfvqJ7Wv4ljH/4rfxOul/8ADvJugYe19fOQV5ZUVVVVVVVVVdVpFn8BBTe+IXL6weYAAAAASUVORK5CYII="/>
                </defs>
            </svg>
            
            <p>Mercredi 15 septembre</p>
      </div>


      <div id="arrow-display">
            <!-- Flèche rouge pour dérouler la description -->
            <svg id="arrow" onclick="revealContent()" width="42" height="24" viewBox="0 0 42 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21L39 3" stroke="#CC3345" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
      </div>

  </div>

  <div id="description" style="display: none;">
      <p>Lorem ipsum dolor sit amet consectetur. Egestas eget aenean curabitur quis eleifend diam fermentum vitae. Tortor feugiat suspendisse faucibus ante. </p>
      <p>IMAGES</p>
      <p>Lien du shotgun : <a href="https://shotgun.fr/aprem-ninjas"> https://shotgun.fr/aprem-ninjas</a></p>
      <p>Sed lorem eu purus suspendisse etiam libero duis placerat magna. Nibh tempor morbi integer curabitur senectus commodo gravida nunc cras...
          Justo cras sit eu viverra egestas. Varius faucibus tristique nulla cursus malesuada ut. Lobortis enim orci gravida cursus enim. Parturient augue.</p>
  </div>

</div>

<!-- Script qui commqnde la révélation du contenu du post  -->

<script>
  const content = document.getElementById("description")
  const arrow = document.getElementById("arrow")

  var contentState = true
  

  function revealContent(event) {

      if(contentState) {
          content.style.display = "none"
          arrow.style.transform = 'rotate(0deg)'
          contentState = false
      } else {
          content.style.display = "block"
          arrow.style.transform = 'rotate(180deg)'
          contentState = true
      }
  }

  content.addEventListener("click", revealContent())

</script>

<!-- Style général du component -->

<style>

  #event {
    background-color: #2E2E33;
    color: white;
    border-radius: 15px;
    padding: 15px;
    margin: 15px;
    }

    #header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    #description {

    }

    .tags {
        display: flex;
        flex-direction: row;
    }

    .tag {
        background-color: #CC3345;
        border-radius: 100px;

        font-size: 12px;
        align-items: center;

        margin-left: 5px;
        margin-right: 5px;

        padding-left: 15px;
        padding-right: 15px;
    }

    .thumbnail {
        border-radius: 200px;
        width: 10%;
        height: 10%;
    }

    .details {
        margin-left: 10px;
        margin-right: 10px;
    }

    #main-title {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    #main-title>p {
        
    }

    #release-date {
        margin-left: 10px;
        margin-right: 10px;
        display: flex;
        flex
    }

    #arrow-display {
        margin-left: 10px;
        margin-right: 10px;
        cursor: pointer;
    }

    body {
        background-color: #17191B;
        color: white;
    }
</style>