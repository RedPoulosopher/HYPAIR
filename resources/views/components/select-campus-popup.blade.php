<div id="select-campus">
    <div id="popup-content" class="popup card">
        <h2>Sélectionnez votre campus</h2>
        @php
        use App\Models\Site;
        $sites = Site::select('*')->get();
        @endphp
    
        <div id="liste-campus">
            @foreach($sites as $site)
                {{-- ucwords pour avoir les majuscules au début des mots --}}
                <a href="">{{ ucwords($site->label) }}</a>
            @endforeach
        </div>
    </div>
</div>