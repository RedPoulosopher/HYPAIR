// Notifications
self.addEventListener('push', function (event) {
    const notification = event.data.json()
    
    const notifContent = notification.notification
    const notifData = notification.data

    console.log(notification)

    event.waitUntil(self.registration.showNotification(notifContent.title, {
        body: notifContent.body,
        icon: "images/logo_air.png",
        badge: "images/logo_air.png",
        data: {
            notifUrl: notifData.url // url quand on clique
        }
    }))
})

self.addEventListener('notificationclick', (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifUrl))
})