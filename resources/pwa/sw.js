const VERSION = 1;

var CURRENT_CACHE = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/css/default.css',
    '/css/offline.css',
    '/images/offline.svg',
    '/images/icons/icon-48x48.png',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    skipWaiting();
    event.waitUntil(
        caches.open(CURRENT_CACHE)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== CURRENT_CACHE))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

//Offline first strategy
self.addEventListener('fetch', function (event) {
    event.respondWith(
        // Try the network
        fetch(event.request)
            .then(function (res) {
                return caches.open(CURRENT_CACHE)
                    .then(function (cache) {
                        // Put in cache if succeeds
                        // cache.put(event.request.url, res.clone());
                        return res;
                    })
            })
            .catch(function (err) {
                // If not online, fallback to cache
                return caches.match(event.request)
                    .then(function (res) {
                        if (res === undefined) {
                            //If not in cache, return fallback offline page
                            return caches.match('/offline');
                        }
                        return res;
                    })
            })
    );
});


// Notifications
self.addEventListener('push', function (event) {
    notification = event.data.json()

    event.waitUntil(self.registration.showNotification(notification.title, {
        body: notification.body,
        icon: "logo_air.png",
        data: {
            notifUrl: notification.url // url quand on clique
        }
    }))
})

self.addEventListener('notificationclick', (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifUrl))
})