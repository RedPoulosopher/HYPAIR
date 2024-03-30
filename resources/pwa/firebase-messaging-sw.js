// Notifications
self.addEventListener('push', function (event) {
    notification = event.data.json()
    console.log(notification)

    // 'notification' => [
    //     'title' => $title,
    //     'body' => $body
    // ],
    // 'topic' => $topic

    event.waitUntil(self.registration.showNotification(notification.title, {
        body: notification.body,
        icon: "logo_air.png",
        // data: {
        //     notifUrl: notification.url // url quand on clique
        // }
    }))
})

self.addEventListener('notificationclick', (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifUrl))
})