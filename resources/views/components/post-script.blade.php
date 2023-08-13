<script>
    // Ce script commande l'affichage des descriptions des posts

    // Ajouter un EventListener sur chaque flèche rouge
    arrows = document.getElementsByClassName("arrow")

    // Cacher les descriptions des posts
    descriptions = document.getElementsByClassName("description")

    // Commander l'affichage des descriptions
    for (let i = 0; i < arrows.length; i++) {
        arrows[i].addEventListener("click", (event) => {

            elementName = event.currentTarget.id
            console.log(elementName)
            descriptionName = "description"

            if (elementName != "") {
                number = elementName.split('-')[1]
                descriptionName = descriptionName + '-' + number

                console.log(descriptionName)
                console.log(number)

                //Toggle description
                description = document.getElementById(descriptionName)
                description.classList.toggle("visible");
                if (description.style.maxHeight) {
                    description.style.maxHeight = null;
                } else {
                    description.style.maxHeight = description.scrollHeight + "px"; //On utilise max-height pour animer l'affichage de la description
                }
                //Rotation de la flèche
                event.currentTarget.classList.toggle("visible");
            }

        })
    }
</script>