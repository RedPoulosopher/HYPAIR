<div id="select-popup" class="popup visible">
    <div class="popup-content card">
        @php
        use App\Models\Site;
        $sites = Site::select('*')->get();
        @endphp

        @if(Auth::user()->promo == NULL && False)
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
                @foreach($sites as $site)
                    <a href="/choix-campus/{{ $site->id }}">{{ ucwords($site->label) }}</a>
                @endforeach
                <a href="/choix-campus/1-2">Douai &<br>Villeneuve-d'Ascq</a>
            </div>
        @endif
    
    </div>
</div>
