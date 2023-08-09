@extends('layouts.app')

@section('titre', 'Post')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>{{ $titre ?? "Créer un post"}}</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue ! Ici vous pourrez créer un post.</p>
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
                        <input type="text" name="titre" class="input" id="titre_doc" required
                            value="{{ old('titre') ?? ($evenement->titre ?? '') }}" />
                    </label>
                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Description du post :</p>
                        <textarea name="description" pattern=".{30,250}" required
                            title="Au moins 30 caractères dans la description, et au plus 250" rows="5">{{ old('description') ?? ($evenement->description ?? '') }}</textarea>
                    </label>
                </div>

                <details>
                    <summary><h2>Options avancées</h2></summary>
                        <div class="groupe card">
                            <label class="input_groupe">
                                <p class="titre">Rattaché à l'event :</p>
                                <select name="campus_id" class="input" spellcheck="false">
                                    <option value="-1" selected>Aucun</option>
                                    @foreach($events_existants as $event)
                                        <option value="{{ $event->id }}">{{ $event->titre }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
        
                        <div class="groupe card">
                            <label class="input_groupe">
                                <p class="titre">Date de publication :</p>
                                <input type="datetime-local" name="date_apparition" class="input" min="01-01-2023"
                                    max="12-31-2099" />
                            </label>
                            <label class="input_groupe">
                                <p class="titre">Date d'expiration :</p>
                                <input type="datetime-local" name="temps_fin" class="input" required
                                    value="{{ old('temps_fin') ?? ($evenement->fin_mise_en_avant ?? '') }}" min="2000-01-01"
                                    max="2100-12-31" />
                            </label>
                        </div>
        
        
                        <div class="groupe card">
                            <label class="input_groupe">
                                <p class="titre">Campus</p>
                                <p class="description">Post destiné aux étudiants de quel campus ?</p>
                                <select name="campus_id" class="input" spellcheck="false">
                                    <option value="0" selected>Tous</option>
                                    <option value="1">Douai</option>
                                    <option value="2">Lille</option>
                                    <option value="3">Valenciennes</option>
                                    <option value="4">Dunkerque</option>
                                    <option value="5">Alençon</option>
                                </select>
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
                    style="float:right;"><span>{{ $evenement->id ?? false ? 'MODIFIER' : 'CRÉER' }}</span></button>
            </form>
        </section>
    </main>

@endsection
