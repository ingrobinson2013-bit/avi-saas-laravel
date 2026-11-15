const CACHE_NAME = 'biolab-pedidos-pwa-v1';

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k))
            )
        ).then(() => self.clients.claim())
    );
});

// Network-first para mantener siempre los pedidos en vivo al día
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});

// Recepción de Notificaciones Push en segundo plano (incluso con app cerrada)
self.addEventListener('push', (event) => {
    let data = {
        title: 'AVIPET BioLab®',
        body: 'Tienes una nueva actividad en tu tienda.',
        url: '/biolab/pedidos?pin=2026',
        tag: 'biolab-alert',
        icon: '/brand/favicons/favicon-192.png',
        badge: '/brand/favicons/favicon-192.png',
        requireInteraction: true,
    };

    if (event.data) {
        try {
            const parsed = event.data.json();
            data = { ...data, ...parsed };
        } catch (e) {
            data.body = event.data.text() || data.body;
        }
    }

    const options = {
        body: data.body,
        icon: data.icon || '/brand/favicons/favicon-192.png',
        badge: data.badge || '/brand/favicons/favicon-192.png',
        tag: data.tag || 'biolab-alert',
        renotify: true,
        requireInteraction: data.requireInteraction !== false,
        vibrate: [250, 120, 250, 120, 350],
        data: {
            url: data.url || '/biolab/pedidos?pin=2026',
        },
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// Al tocar la notificación, abrir o enfocar la PWA en el panel de pedidos
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const targetUrl = (event.notification.data && event.notification.data.url) || '/biolab/pedidos?pin=2026';

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url.includes('/biolab/pedidos') && 'focus' in client) {
                    return client.focus();
                }
            }
            if (self.clients.openWindow) {
                return self.clients.openWindow(targetUrl);
            }
        })
    );
});
