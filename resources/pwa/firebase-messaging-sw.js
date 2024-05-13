self.addEventListener("install", event => {
    skipWaiting();
});

// Notifications
self.addEventListener('push', async (event) => {
    const payload = event.data.json()
    
    const notifContent = payload.notification
    const notifData = payload.data

    console.log(payload)

    // Create notification objects
    let notificationTitle = notifContent.title || "Nouvelle notification";
    let notificationOptions = {
        body: notifContent.body,
        icon: notifData.icon ?? "images/notifications/logo_air_carre.png",
        badge: "images/notifications/badge.png",
        data: {
            notifUrl: notifData.url, // url quand on clique
        }
    };

    if(notifData.tag == "POST"){
        // On ajoute à la notifications les infos de tag
        notificationOptions.tag = notifData.tag //Permet d'écraser les précédentes notifications ayant le même tag sans renotifier l'utilisateur
    
        // On stocke des données dans la notification client afin de pouvoir les récupérer par exemple si on veut fusionner 2 notifications par la suite
        notificationOptions.data.NB_POSTS = 1                 // Le nombre de posts s'il y en a plusieurs
        notificationOptions.data.ENTITES = [notifData.entite] // La liste des entités qui ont posté




        // On regarde s'il y a déjà une notification avec ce tag
        const currentNotification = await getCurrentNotifWithTag(notifData.tag) //On vérifie si une notification n'est pas déjà présente pour les fusionner
        // S'il y a déjà une notification avec le tag "POST", on les fusionne
        if(currentNotification){
            // On indique qu'il y a un post supplémentaire
            notificationOptions.data.NB_POSTS = parseInt(currentNotification.data.NB_POSTS) + 1

            // On stocke la liste des entités qui ont posté (sans duplicata)
            notificationOptions.data.ENTITES = [...new Set(currentNotification.data.ENTITES.concat(notificationOptions.data.ENTITES))];
    
            // On change le lien pour rediriger vers la page d'accueil
            notificationOptions.data.notifUrl = "/"
            // Quand il y a plusieurs posts d'entités différentes, l'image est le logo de l'air
            if(notificationOptions.data.ENTITES.length > 1){
                notificationOptions.icon = "images/notifications/logo_air_carre.png"
            }
            
            // On change le titre
            notificationTitle = notificationOptions.data.NB_POSTS + " nouveaux posts"
            // On change le texte
            if(notificationOptions.data.ENTITES.length > 3){
                entityList = notificationOptions.data.ENTITES.filter((element,index) => index < 3);
                notificationOptions.body = "De " + entityList.join(", ") + "..."
            }else{
                notificationOptions.body = "De " + notificationOptions.data.ENTITES.join(", ")
            }
        }
    }

    //Envoi de la notif fusionnée
    return registration.showNotification(notificationTitle,notificationOptions);

})

const getCurrentNotifWithTag = async (tag)=>{
    const notifications = await registration.getNotifications()

    for (let i = 0; i < notifications.length; i++) {
        if (notifications[i].tag && notifications[i].tag == tag) {
            return notifications[i];
        }
    }

    return null

}

self.addEventListener('notificationclick', (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifUrl));
})