@extends('layouts.app')
@section('titre', 'Campagnes')
@pushonce('styles')
    @vite([
        'resources/css/entite/entite.scss',
        'resources/css/components/entite.scss',
    ])
@endpushonce
@section('content')
    <main id="main-content">
        <section>
            @if (Auth::check())
                @if (count($bureaux) > 0)
                    {{-- La boucle foreach marche, mais on fait manuellement pour contrôler l'ordre des bdx sur la page --}}
                    {{-- @foreach ($bureaux as $bureau)
                        @if (!$bureau->hidden)
                            <h1>Listes {{ $bureau->nom }}</h1>
                            @if (count($listes[$bureau->ratachement->value]) > 0)
                                <div class="liste_comite_club">
                                    @foreach ($listes[$bureau->ratachement->value] as $liste)
                                        @if (!$liste->hidden)
                                            <x-entite :asso="$liste" :destination="$liste->lien_relatif()" score-visible />
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p>Pas de listes pour l'instant.</p>
                            @endif
                        @endif
                        @endforeach --}}
                    <h1>Listes BDA</h1>
                    <h2>Du 09/01 au 19/01</h2>
                    <div class="liste_comite_club">
                        @if (count($listes['bda']) > 0)
                            @foreach ($listes['bda'] as $liste)
                                @if (!$liste->hidden)
                                    <x-entite :asso="$liste" :destination="$liste->lien_relatif()" score-visible />
                                @endif
                            @endforeach
                        @else
                            @for ($i = 0; $i < 3; $i++)
                                <div class="entite">
                                    <div class="logo ombre_petite">
                                        <div class="cercle" style="border-color: var(--couleur_police_secondaire)"></div>
                                        <img src="{{ Vite::Image('interrogation.png') }}" />
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <h1>Listes BDH</h1>
                    <h2>Du 07/02 au 13/02</h2>
                    <div class="liste_comite_club">
                        @if (count($listes['bdh']) > 0)
                            @foreach ($listes['bdh'] as $liste)
                                @if (!$liste->hidden)
                                    <x-entite :asso="$liste" :destination="$liste->lien_relatif()" score-visible />
                                @endif
                            @endforeach
                        @else
                            @for ($i = 0; $i < 3; $i++)
                                <div class="entite">
                                    <div class="logo ombre_petite">
                                        <div class="cercle" style="border-color: var(--couleur_police_secondaire)"></div>
                                        <img src="{{ Vite::Image('interrogation.png') }}" />
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <h1>Listes BDE</h1>
                    <h2>Du 24/02 au 03/03</h2>
                    <div class="liste_comite_club">
                        @if (count($listes['bde']) > 0)
                            @foreach ($listes['bde'] as $liste)
                                @if (!$liste->hidden)
                                    <x-entite :asso="$liste" :destination="$liste->lien_relatif()" score-visible />
                                @endif
                            @endforeach
                        @else
                            @for ($i = 0; $i < 3; $i++)
                                <div class="entite">
                                    <div class="logo ombre_petite">
                                        <div class="cercle" style="border-color: var(--couleur_police_secondaire)"></div>
                                        <img src="{{ Vite::Image('interrogation.png') }}" />
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <h1>Listes BDS</h1>
                    <h2>Du 04/03 au 11/03</h2>
                    <div class="liste_comite_club">
                        @if (count($listes['bds']) > 0)
                            @foreach ($listes['bds'] as $liste)
                                @if (!$liste->hidden)
                                    <x-entite :asso="$liste" :destination="$liste->lien_relatif()" score-visible />
                                @endif
                            @endforeach
                        @else
                            @for ($i = 0; $i < 3; $i++)
                                <div class="entite">
                                    <div class="logo ombre_petite">
                                        <div class="cercle" style="border-color: var(--couleur_police_secondaire)"></div>
                                        <img src="{{ Vite::Image('interrogation.png') }}" />
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                @else
                    <p class="should-be-connected no-content">Les campagnes arriveront plus tard</p>
                @endif
            @else
                <p class="should-be-connected no-content">Vous devez être connecté pour voir les listes</p>
            @endif
        </section>
    </main>

@endsection
