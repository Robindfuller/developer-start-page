/* Service Worker for offline mode - caches page when online for use when server is unavailable */
const CACHE_NAME = 'dev-start-page-v1';
const CDN_SCRIPTS = [
  'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js',
  'https://cdn.jsdelivr.net/npm/webaudiofont@3.0.4/npm/dist/WebAudioFontPlayer.min.js',
  'https://cdn.jsdelivr.net/npm/webaudiofont@3.0.4/examples/MIDIFile.js'
];

self.addEventListener('install', function(e) {
  e.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return Promise.allSettled(CDN_SCRIPTS.map(function(url) { return cache.add(url); }));
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', function(e) {
  e.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(keys.filter(function(k) { return k !== CACHE_NAME; }).map(function(k) { return caches.delete(k); }));
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', function(e) {
  var url = e.request.url;
  var isDoc = e.request.mode === 'navigate' || (e.request.method === 'GET' && e.request.destination === 'document');
  var isCdnScript = CDN_SCRIPTS.some(function(a) { return url.startsWith(a.split('?')[0]); });

  if (!isDoc && !isCdnScript) return;

  e.respondWith(
    fetch(e.request).then(function(res) {
      if (res.ok) {
        var clone = res.clone();
        caches.open(CACHE_NAME).then(function(cache) {
          cache.put(e.request, clone);
        });
      }
      return res;
    }).catch(function() {
      return caches.match(e.request).then(function(cached) {
        return cached || (isDoc ? caches.open(CACHE_NAME).then(function(cache) {
          return cache.keys().then(function(reqs) {
            var docReq = reqs.find(function(r) {
              try {
                var p = new URL(r.url).pathname;
                return p === '/' || p === '/index.php' || r.url.includes('index.php');
              } catch (_) { return false; }
            });
            return docReq ? cache.match(docReq) : null;
          });
        }) : null);
      }).then(function(cached) {
        return cached || Promise.reject(new Error('offline'));
      });
    })
  );
});
