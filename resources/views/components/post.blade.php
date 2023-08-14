{{-- COMPONENT des évènements de la page d'accueil --}}

@php
use App\Http\Controllers\PostController;
@endphp

<article id="post" class="card">

    <div class="header">

        <img class="thumbnail" src="/images/logo-air-rond-test.png" alt="AIR">

        <div class="details">
            <h2>{{ $post->titre }}</h2>
            <p>Posté par {{ $post->entite->nom }}<span class="separator">•</span>Il y a {{ PostController::date_apparition_to_duration($post->date_apparition)}}</p>

            <div class="tags">
                <div class="tag" style="background-color: {{ PostController::stringToColorCode('IMPORTANT') }};">
                    <p>IMPORTANT</p>
                </div>
                <div class="tag" style="background-color: {{ PostController::stringToColorCode('BDH') }};">
                    <p>BDH</p>
                </div>
                <div class="tag" style="background-color: {{ PostController::stringToColorCode('Gala') }};">
                    <p>Gala</p>
                </div>
                <div class="tag" style="background-color: {{ PostController::stringToColorCode('Soirée') }};">
                    <p>Soirée</p>
                </div>
                <div class="tag" style="background-color: {{ PostController::stringToColorCode('test') }};">
                    <p>test</p>
                </div>
            </div>

        </div>

        <div class="arrow-display">
            {{-- Flèche rouge pour dérouler la description --}}
            <svg class="arrow" id="arrow-{{$post->id}}" width="42" height="24" viewBox="0 0 42 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21L39 3" stroke="#CC3345" stroke-width="6" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

    </div>

    <div class="description" id="description-{{$post->id}}">
        {!! Str::markdown(strip_tags($post->description ?? ($entite->description_courte ?? ''))) !!}
    </div>

</article>


@pushonce('end-scripts')
@include('components.post-script')
@endpushonce