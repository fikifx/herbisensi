const CACHE_NAME = 'herbi-sense-v1.1';
const ASSETS_TO_CACHE = [
  '/',
  '/beranda',
  '/css/herbi.css',
  '/js/herbi.js',
  '/js/barcode.js',
  '/js/ai-scan.js',
  '/manifest.json'
];

self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
});

self.addEventListener('fetch', (e) => {
  // Hanya intercept GET request (biarkan POST API tetap jalan)
  if (e.request.method !== 'GET') return;
  
  e.respondWith(
    fetch(e.request).catch(() => {
      return caches.match(e.request).then((res) => {
        if (res) return res;
        // Jika offline dan tidak ada di cache, arahkan ke offline page atau index (jika disetup)
      });
    })
  );
});
