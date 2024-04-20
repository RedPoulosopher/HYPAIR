<div id="select-popup" class="popup">
    <div id="popup-content" class="card">

        <h2>Autoriser les notifications ?</h2>
        <div id="liste-choix">
            <a href="" onclick="choixNotifs(event, true)">Oui</a>
            <a href="" onclick="choixNotifs(event, false)">Non</a>
        </div>
    
    </div>
</div>

<script>

var popup = document.getElementById("select-popup")

// If first time, show popup
if(localStorage.getItem("notifications-authorized") == null){
    popup.classList.add("visible")
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