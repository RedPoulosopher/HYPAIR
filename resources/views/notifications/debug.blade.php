@extends('layouts.app-without-sidebar')

@section('titre', 'À propos')

@section('content')
<main id="main-content">
    <section>
        <h1>Infos notifications</h1>
        <div class="article-wrapper">
            <h2>UserAgent</h2>
            <p id="user-agent"></p>
            
            <h2>Service workers</h2>
            <ul id="sw"></ul>

            <h2>Notifications status</h2>
            <p id="notifications-authorized"></p>

            <div id="token-section">
                <h2>Notification token</h2>
                <p id="notification-token"></p>
            </div>
        </div>
    </section>
@endsection

@pushonce('styles')
<style>
    p,li{
        word-break: break-all;
        font-weight: var(--fw-thin)
    }
</style>
@endpushonce

@pushonce('end-scripts')
<script>
    // Check if user logged in
    var loggedIn = {!! json_encode(Auth::check()) !!}

    // User agent
    var userAgent = document.getElementById("user-agent")
    userAgent.innerHTML = window.navigator.userAgent.toLowerCase();

    // Service workers
    var sw = document.getElementById("sw")
    navigator.serviceWorker.getRegistrations().then(registrations => {
        sw.innerHTML = registrations.map(r => {
            return "<li>" + r.active.scriptURL + " ➡️ " + capitalizeFirstLetter(r.active.state)  + "</li>"
        }).join('')
    });

    // Check if user has authorized notifications in the browser
    var notificationsAuthorized = document.getElementById("notifications-authorized")
    const icon = Notification.permission == "granted" ? "✅" 
                                                      : (Notification.permission == "denied" ? "🚫" : "❓") 
    notificationsAuthorized.innerHTML = icon + " " + capitalizeFirstLetter(Notification.permission)

    // Show device notification token
    var notificationToken = document.getElementById("notification-token")
    if(Notification.permission == "granted" && loggedIn){
        notificationToken.innerHTML = "Chargement..."
        window.getNotifToken("{{ env('FCM_VAPID_PUBLIC_KEY') }}").then(token => {
            notificationToken.innerHTML = token
        })
    }else{
        var token = document.getElementById("token-section")
        token.classList.add('hidden')
    }

    // Helper function
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
</script>
@endpushonce