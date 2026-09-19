@pushonce('styles')
    @vite('resources/css/adherants/card_view.scss')
@endpushonce
<div class="card_viewer">
    <svg id="svg info-card" class="bg-svg" viewBox="0 0 900 540" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
        <rect width="900" height="540" fill="#FFD000" />
        <path d="M0,400 C200,300 700,600 900,400 L900,540 L0,540 Z" fill="#009739" />
    </svg>
    <div class="content">
        <div class="brand">
            <img src="https://dinguerie-imt.web.app/logo_bde.jpg" id="image-logo info-card" alt="Logo">
            <div id="brand-text info-card">
                <div class="title info-card" id="title info-card">{{--$card->card_model->entity_name --}}</div>
                <div class="subtitle info-card" id="subtitle info-card">{{-- $card->card_model->subtitle --}}</div>
            </div>
        </div>

        <div class="member">
            <div class="avatar">
                <img src="https://e-services.imt-nord-europe.fr/images/photos/etudiants/1910000016067.jpg" id="image-id info-card" alt="Photo membre" />
            </div>
            <div class="member-info" id="member-info info-card">
                <div id="user_name info-card" class="name info-card">{{-- $card->user_name --}}</div>
                <div id="poste info-card" class="role info-card">{{-- $card->uid_admin --}}</div>
                <div id="date info-card" class="chip info-card">Valable jusqu'à la fin de vos études {{-- $card->expiration_date --}}</div>
            </div>
        </div>
    </div>
</div>