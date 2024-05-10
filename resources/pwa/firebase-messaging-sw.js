self.addEventListener("install", event => {
    skipWaiting();
});

// Notifications
self.addEventListener('push', function (event) {
    const notification = event.data.json()
    
    const notifContent = notification.notification
    const notifData = notification.data

    console.log(notification)

    event.waitUntil(self.registration.showNotification(notifContent.title, {
        body: notifContent.body,
        icon: "images/notifications/logo_air_carre.png",
        badge: "images/notifications/badge.png",
        data: {
            notifUrl: notifData.url // url quand on clique
        }
    }))
})

self.addEventListener('notificationclick', (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifUrl))
})