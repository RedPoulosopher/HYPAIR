<div id="select-popup" class="popup">
    <div class="popup-content card" id="choix">

        <h2>Autoriser les notifications ?</h2>
        <div id="liste-choix">
            <a href="" onclick="choixNotifs(event, true)">Oui</a>
            <a href="" onclick="choixNotifs(event, false)">Non</a>
        </div>
    
    </div>

    <div class="popup-content card hidden" id="info">
        <h2>Votre navigateur ne supporte pas les notifications :(</h2>
        <p>Essayez en un autre (Chrome par exemple) si vous souhaitez les recevoir</p>
        
        <div id="liste-choix">
            <a href="" onclick="choixNotifs(event, false)">OK</a>
        </div>
    </div>
</div>

<script>

var popup = document.getElementById("select-popup")
var listeChoix = document.getElementById("choix")
var unsupportedText = document.getElementById("info")

// If first time seing popup, show popup
var popupAlreadySeen = localStorage.getItem("notifications-authorized") != null
if(!popupAlreadySeen){
    popup.classList.add("visible")
}
// If browser doesn't support notifications, change popup text to tell user to change browser
var supportsNotifications = 'Notification' in window
if(!supportsNotifications && !popupAlreadySeen){
    unsupportedText.classList.remove("hidden")
    listeChoix.classList.add("hidden")
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