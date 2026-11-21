{{-- Side bar : planning de la semaine --}}
<aside id="side-bar">

    <div id="calendrier-sidebar">
        <h1>Cette semaine</h1>
        {{--@php
            use App\Http\Controllers\EvenementController;
            $comingEvents = EvenementController::comingEvents();
        @endphp--}}

        @if (Auth::check() && False && count($comingEvents) > 0)
            @foreach ($comingEvents as $comingEvent)
                <x-coming-event :title="$comingEvent->titre" :start="$comingEvent->temps_debut" :end="$comingEvent->temps_fin" :entite="$comingEvent->entite_nom"
                    :uid="$comingEvent->uid" :slug="$comingEvent->slug" />
            @endforeach
            <a id="voir-plus" href="/calendrier">Voir plus</a>
        @elseif(Auth::check() && False)
            <p>Aucun évènement dans les 7 prochains jours</p>
        @else
            <p class="should-be-connected no-content">Vous devez être connecté pour voir les événements</p>
        @endif

    </div>
</aside>

@push('styles')
    @vite('resources/css/importants/layout.scss')
@endpush
