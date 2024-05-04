<div id="select-popup" class="popup">
    <div class="popup-content card" id="supported">

        <h2>Autoriser les notifications ?</h2>
        <div id="liste-choix">
            <a href="" onclick="choixNotifs(event, true)">Oui</a>
            <a href="" onclick="choixNotifs(event, false)">Non</a>
        </div>
    
    </div>

    <div class="popup-content card hidden" id="not-supported">
        <div id="not-supported-android" class="hidden">
            <h2>Votre navigateur ne supporte pas les notifications :(</h2>
            <p>Essayez en un autre (Chrome par exemple) si vous souhaitez les recevoir</p>
        </div>
        <div id="not-supported-iOS" class="hidden">
            <h2>Les notifications ne sont pas autorisées dans le navigateur :(</h2>
            <p>Installez l'application pour pouvoir les activer (<a href="https://partage.imt.fr/index.php/s/bH7fpPMqdCmGtAX?path=%2FTutos%20HypAIR">voir tuto</a>)</p>    
        </div>
        <div id="too-old-iOS" class="hidden">
            <h2>Les notifications ne sont pas autorisées dans le navigateur :(</h2>
            <p>Désolé, votre téléphone est trop vieux. Les notifications ne fonctionnent qu'à partir d'iOS 16.4.</p>    
        </div>
        
        <div id="liste-choix">
            <a href="" onclick="choixNotifs(event, false)">OK</a>
        </div>
    </div>

</div>

<script>

var popup = document.getElementById("select-popup")
var supportedContent = document.getElementById("supported")
var notSupportedContent = document.getElementById("not-supported")
var notSupportedTextAndroid = document.getElementById("not-supported-android")
var notSupportedTextIos = document.getElementById("not-supported-iOS")
var tooOldtextIos = document.getElementById("too-old-iOS")

// If first time seing popup, show popup
var popupAlreadySeen = localStorage.getItem("notifications-authorized") != null
if(!popupAlreadySeen){
    popup.classList.add("visible")
}


// If browser doesn't support notifications, change popup text to tell user to change browser / install PWA
const isIos = () => {
  const userAgent = window.navigator.userAgent.toLowerCase();
  return /iphone|ipad|ipod/.test( userAgent );
}
const iosVersion = /iP(hone|ad|od) OS ([1-9]*_[1-9]*)/i.exec(window.navigator.userAgent)?.[2].replace('_','.') || NaN

var supportsNotifications = 'Notification' in window
if(!supportsNotifications && !popupAlreadySeen){
    // Hide default authorization text
    supportedContent.classList.add("hidden")
    // Show error
    notSupportedContent.classList.remove("hidden")

    //Change error
    if(isIos){
        if(iosVersion >= 16.4){
            // Tell the user that notifications are only possible in the PWA
            notSupportedTextIos.classList.remove("hidden")
        }else{
            // Tell the user its phone is too old to have notifications
            tooOldtextIos.classList.remove("hidden")
        }
    }else{
        // On Android, tell the user to change browser if not working
        notSupportedTextAndroid.classList.remove("hidden")
    }
}


function choixNotifs(event, choix) {
    // Prevent link action
    event.preventDefault()

    // Store selected choice to not show popup again
    localStorage.setItem("notifications-authorized", choix);

    // Hide popup
    popup.classList.remove("visible")

    if(choix == true){
        window.setupNotifications("{{ env('FCM_VAPID_PUBLIC_KEY') }}")
    }
}
    
    
    
</script>