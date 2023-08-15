@extends('layouts.app-without-sidebar')

@section('titre', 'Évènements')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/evenements/formulaire.css') }}" type="text/css">
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>{{ $titre ?? 'Créer un évènement' }}</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue ! Ici vous pourrez créer un évènement.</p>
            @endif
            <form method="POST">
                @csrf
                @if ($errors->any())
                    <div class="erreurs">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Titre :</p>
                        {{-- On peut tout simplifier avec la directive @selected et @checked --}}
                        @isset($event)
                            <input type="text" name="titre" class="input" id="titre_doc" required
                                value="{{ $event->titre }}" />
                        @endisset
                        @empty($event)
                            <input type="text" name="titre" class="input" id="titre_doc" required
                                value="{{ old('titre') ?? ($evenement->titre ?? '') }}" />
                        @endempty
                    </label>
                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Description de l'évènement :</p>
                        @isset($event)
                            <textarea name="description" pattern=".{30,250}" required
                                title="Au moins 30 caractères dans la description, et au plus 250" rows="5">{{ $event->description }}</textarea>
                        @endisset
                        @empty($event)
                            <textarea name="description" pattern=".{30,250}" required
                                title="Au moins 30 caractères dans la description, et au plus 250" rows="5">{{ old('description') ?? ($evenement->description ?? '') }}</textarea>
                        @endempty
                    </label>


                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Début de l'évènement :</p>
                        @isset($event)
                            <input type="datetime-local" name="temps_debut" class="input" required
                                value="{{ $event->temps_debut }}" min="01-01-2000" max="12-31-2099" />
                        @endisset
                        @empty($event)
                            <input type="datetime-local" name="temps_debut" class="input" required
                                value="{{ old('temps_debut') ?? ($evenement->fin_mise_en_avant ?? '') }}" min="01-01-2000"
                                max="12-31-2099" />
                        @endempty
                    </label>


                    <label class="input_groupe">
                        <p class="titre">* Fin de l'évènement :</p>
                        @isset($event)
                            <input type="datetime-local" name="temps_fin" class="input" required
                                value="{{ $event->temps_fin }}" min="2000-01-01" max="2100-12-31" />
                        @endisset
                        @empty($event)
                            <input type="datetime-local" name="temps_fin" class="input" required
                                value="{{ old('temps_fin') ?? ($evenement->fin_mise_en_avant ?? '') }}" min="2000-01-01"
                                max="2100-12-31" />
                        @endempty
                    </label>
                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Pour les cotisants :</p>
                        <p class="description">Evènement seulement ouvert aux cotisants ?</p>
                        <select name="pour_cotisant" class="input" spellcheck="false" required
                            select="{{ old('pour_cotisant') ?? ($evenement->pour_cotisant ?? '') }}">
                            @if ((isset($event) && $event->pour_cotisant) || !isset($event))
                                <option value="1" selected>Oui</option>
                                <option value="0">Non</option>
                            @else
                                <option value="1">Oui</option>
                                <option value="0" selected>Non</option>
                            @endif
                        </select>
                    </label>
                </div>

                <details>
                    <summary>
                        <h2>Options avancées</h2>
                    </summary>
                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Lieu :</p>
                            @isset($event)
                                <input type="text" name="lieu" class="input" id="lieu_evenement"
                                    value="{{ $event->lieu }}" />
                            @endisset
                            @empty($event)
                                <input type="text" name="lieu" class="input" id="lieu_evenement"
                                    value="{{ old('lieu') ?? ($evenement->lieu ?? '') }}" />
                            @endempty
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Date de publication :</p>
                            @isset($event)
                                <input type="datetime-local" name="date_apparition" class="input" min="01-01-2023"
                                    max="12-31-2099" value="{{ $event->date_apparition }}" />
                            @endisset
                            @empty($event)
                                <input type="datetime-local" name="date_apparition" class="input" min="01-01-2023"
                                    max="12-31-2099" />
                            @endempty
                        </label>
                    </div>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Nombre maximum de participants :</p>
                            @isset($event)
                                <input type="number" name="max_participation" class="input"
                                    id="max_participation_evenement" value="{{ $event->max_participation }}"
                                    min="0" />
                            @endisset
                            @empty($event)
                                <input type="number" name="max_participation" class="input"
                                    id="max_participation_evenement"
                                    value="{{ old('max_participation') ?? ($evenement->max_participation ?? '') }}"
                                    min="0" />
                            @endempty
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Campus</p>
                            <p class="description">Évènement destiné aux étudiants de quel campus ?</p>
                            <ul id="campus_id">
                                @foreach ($campus as $campus)
                                    @if ((isset($event) && $event->campus_id == $campus->id) || (!isset($event) && $campus->id == 1))
                                        <li><input type="checkbox" name="campus_id_{{ $campus->id }}"
                                                id="campus_id_{{ $campus->id }}"
                                                checked>{{ Str::ucfirst($campus->label) }}</li>
                                    @else
                                        <li><input type="checkbox" name="campus_id_{{ $campus->id }}"
                                                id="campus_id_{{ $campus->id }}">{{ Str::ucfirst($campus->label) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </label>
                    </div>
                </details>


                {{-- <label class="input_groupe">
                    <p class="titre">* Confidentialité :</p>
                    <select name="confidentialite" class="input" spellcheck="false" required
                        select="{{ old('confidentialite') ?? ($evenement->confidentialite ?? '') }}">
                        <option value="0" selected>Public</option>
                        <option value="1">Membres de l'association</option>
                        <option value="2">Responsables & bureau</option>
                        <option value="3">Bureau</option>
                        <option value="4">Président⸱e⸱s et vice-président⸱e</option>
                    </select>
                </label> --}}


                <span>* Les champs marqués d'une astérisque sont obligatoires</span>
                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;"><span>{{ isset($event) ? 'MODIFIER' : 'CRÉER' }}</span></button>
            </form>
        </section>
    </main>

@endsection
