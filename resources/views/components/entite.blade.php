<a class="entite" href="{{ $destination }}">
    <div class="logo ombre_petite">
        <div class="cercle" style="border-color: {{ $asso->couleur_sombre }}"></div>
        <img src="{{ $asso->logo_url('petit') }}" />
    </div>
    <div class="info" style="text-align:center;">
        <p class="nom">{{ $asso->nom }}</p>
        @if ($asso->type->value == 'liste')
            @if ($asso->score != null)
                <p class="score">({{ $asso->score }}%)</p>
            @endif
        @endif
    </div>
</a>
