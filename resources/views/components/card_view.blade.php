@pushonce('styles')
    @vite('resources/css/adherants/card_view.scss')
@endpushonce





<div class="card_viewer" style='background-image: url("@isset($cardviewbackground){{ $cardviewbackground }}@endisset");'>
    <svg id="svg info-card" class="bg-svg" viewBox="0 0 900 540" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" @isset($cardviewbackground)style="display: none;@endisset">
        <rect width="900" height="540" fill="@isset($cardviewcouleur1) {{ $cardviewcouleur1 }} @endisset{{-- #FFD000 --}}" />
        <path d="M0,400 C200,300 700,600 900,400 L900,540 L0,540 Z" fill="@isset($cardviewcouleur2) {{ $cardviewcouleur2 }} @endisset{{-- #009739 --}}" />
    </svg>
    <div class="content">
        <div class="brand">
            <img src="@isset($cardviewlogo) {{ $cardviewlogo }} @endisset" id="image-logo info-card" alt="Logo">
            <div id="brand-text info-card">
                <div class="title info-card" id="title info-card" style="color:@isset($cardviewtextcouleur1) {{ $cardviewtextcouleur1 }} @endisset;">@isset($cardviewtitle) {{ $cardviewtitle }} @endisset</div>
                <div class="subtitle info-card" id="subtitle info-card" style="color:@isset($cardviewtextcouleur1) {{ $cardviewtextcouleur1 }} @endisset;">@isset($cardviewsubtitle) {{ $cardviewsubtitle }} @endisset</div>
            </div>
        </div>

        <div class="member">
            <div class="avatar">
                <img src="@isset($cardviewpp) {{ $cardviewpp }} @endisset" id="image-id info-card" alt="Photo membre" />
            </div>
            <div class="member-info" id="member-info info-card">
                <div id="user_name info-card" class="name info-card" style="color:@isset($cardviewtextcouleur2) {{ $cardviewtextcouleur2 }} @endisset;">@isset($cardviewusername) {{ $cardviewusername }} @endisset</div>
                <div id="date info-card" class="chip info-card" style="color:@isset($cardviewtextcouleur2) {{ $cardviewtextcouleur2 }} @endisset;">Valable jusqu'à la fin de vos études {{-- $card->expiration_date --}}</div>
            </div>
        </div>
    </div>
</div>