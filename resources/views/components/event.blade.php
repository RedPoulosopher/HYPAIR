<div id="event">

  <div id="header">

      <img class="thumbnail" src="logo-air.png" alt="AIR">

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
          <p>Mercredi 15 septembre</p>
      </div>


      <div id="arrow-display">
          <img id="arrow" src="arrow.png" alt="Voir plus" onclick="revealContent()">
      </div>

  </div>

  <div id="content" style="display: none;">
      <p>Lorem ipsum dolor sit amet consectetur. Egestas eget aenean curabitur quis eleifend diam fermentum vitae. Tortor feugiat suspendisse faucibus ante. </p>
      <p>IMAGES</p>
      <p>Lien du shotgun : <a href="https://shotgun.fr/aprem-ninjas"> https://shotgun.fr/aprem-ninjas</a></p>
      <p>Sed lorem eu purus suspendisse etiam libero duis placerat magna. Nibh tempor morbi integer curabitur senectus commodo gravida nunc cras...
          Justo cras sit eu viverra egestas. Varius faucibus tristique nulla cursus malesuada ut. Lobortis enim orci gravida cursus enim. Parturient augue.</p>
  </div>

</div>

<!-- Script qui commqnde la révélation du contenu du post  -->

<script>
  const content = document.getElementById("content")
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

#content {

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
}

#arrow-display {
    margin-left: 10px;
    margin-right: 10px;
}

body {
    background-color: #17191B;
    color: white;
}
</style>