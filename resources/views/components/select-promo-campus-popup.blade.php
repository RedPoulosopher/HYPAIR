<div id="select-popup" class="popup visible">
    <div id="popup-content" class="card">
        @php
        use App\Models\Site;
        $sites = Site::select('*')->get();
        @endphp

        @if(Auth::user()->promo == NULL)
            <h2>Sélectionnez votre promo</h2>
            <div id="liste-promos">
                <a href="/choix-promo/CP1">CP1</a>
                <a href="/choix-promo/CP2">CP2</a>
                <a href="/choix-promo/CI1">CI1</a>
                <a href="/choix-promo/CI2">CI2</a>
                <a href="/choix-promo/CI3">CI3</a>
            </div>
        @else
            <h2>Sélectionnez votre campus</h2>
            <div id="liste-campus">
                @if(Auth::user()->promo != 'CP1' && Auth::user()->promo != 'CP2')
                    <a href="/choix-campus/lille-douai">Lille & Douai</a>
                @endif
                @foreach($sites as $site)
                    <a href="/choix-campus/{{ $site->label }}">{{ ucwords($site->label) }}</a>
                @endforeach
            </div>
        @endif
    
    </div>
</div>

<script>

</script>