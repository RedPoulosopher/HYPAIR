<script>
    // Ce script commande l'affichage des descriptions des posts

    // Ajouter un EventListener sur chaque flèche rouge
    arrows = document.getElementsByClassName("arrow-display")

    // Cacher les descriptions des posts
    descriptions = document.getElementsByClassName("description")

    // Commander l'affichage des descriptions
    for (let i = 0; i < arrows.length; i++) {
        arrows[i].addEventListener("click", (event) => {

            elementName = event.target.id
            console.log(elementName)
            descriptionName = "description"

            if (elementName != "") {
                number = elementName.split('-')[1]
                descriptionName = descriptionName + '-' + number

                console.log(descriptionName)
                console.log(number)

                description = document.getElementById(descriptionName)
                
                if (description.style.display === "none") {
                    description.style.display = "block"
                } else {
                    description.style.display = "none"
                }
            }

        })
    }
</script>