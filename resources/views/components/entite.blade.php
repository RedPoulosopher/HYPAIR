<a class="entite" href="{{ $destination }}">
    <div class="logo ombre_petite">
        <div class="cercle" style="border-color: {{ $asso->color_1 }}"></div>
        <img src="{{ $asso->getLogo?->url() }}" />
    </div>
    <div class="info" style="text-align:center;">
        <p class="nom">{{ $asso->name }}</p>
        {{--@if ($asso->type->value == 'liste' && isset($scoreVisible) && $scoreVisible)
            @if ($asso->score != null)
                <p class="score">({{ $asso->score }}%)</p>
            @endif
        @endif--}}
    </div>
</a>
