<div id="pwa-popup">
    <div id="pwa-popup-content">Pour installer HypAIR, cliquez sur l'icône <img src="{{ mix('/images/pwa/ios-share-icon.png') }}" alt="Share"> puis <em>"Sur la page d'accueil"</em></div>
</div>




@pushonce('end-scripts')
<script>
// Detects if device is on iOS 
const isIos = () => {
  const userAgent = window.navigator.userAgent.toLowerCase();
  return /iphone|ipad|ipod/.test( userAgent );
}

// Detects if device is in standalone mode (=opened as PWA)
const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);

// Checks if should display install popup notification:
var pwaPopup = document.getElementById('pwa-popup')
if (isIos() && !isInStandaloneMode()) {
    pwaPopup.classList.add('visible')
}

//Allow closing the popup
pwaPopup.addEventListener('click', (event) => {
    if(event.target.id == 'pwa-popup'){
        pwaPopup.classList.remove('visible')
    }
})
</script>
@endpushonce