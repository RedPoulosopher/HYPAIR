@extends('layouts.vide')

@section('titre', 'Créer un compte')

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>Créer un compte</h1>

            <p class="explication">
                Bienvenue ! Remplissez le formulaire ci-dessous pour créer votre compte.
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                @if ($errors->any())
                    <div class="erreurs">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Informations personnelles --}}
                <h2>Informations personnelles</h2>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Nom :</p>
                        <input type="text" name="nom" class="input" required
                            autocomplete="family-name"
                            value="{{ old('nom') }}" />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">* Prénom :</p>
                        <input type="text" name="prenom" class="input" required
                            autocomplete="given-name"
                            value="{{ old('prenom') }}" />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">Autres prénoms :</p>
                        <input type="text" name="prenoms" class="input"
                            value="{{ old('prenoms') }}" />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">Pronoms :</p>
                        <input type="text" name="pronoms" class="input"
                            placeholder="Ex : il/lui, elle, iel..."
                            value="{{ old('pronoms') }}" />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">Date de naissance :</p>
                        <input type="date" name="date_naissance" class="input"
                            value="{{ old('date_naissance') }}" />
                    </label>
                </div>

                {{-- Contact --}}
                <h2>Coordonnées</h2>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Adresse e-mail :</p>
                        <p class="description">Seulement email en @etu.imt-nord-europe.fr</p>
                        <input type="email" name="email" class="input" required
                            autocomplete="email"
                            value="{{ old('email') }}" />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">Numéro de téléphone :</p>
                        <input type="tel" name="num_tel" class="input"
                            autocomplete="tel"
                            value="{{ old('num_tel') }}" />
                    </label>
                </div>

                {{-- Sécurité --}}
                <h2>Sécurité</h2>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Mot de passe :</p>
                        <input type="password" name="password" class="input" required
                            autocomplete="new-password"/>
                    </label>

                    <label class="input_groupe">
                        <p class="titre">* Confirmation du mot de passe :</p>
                        <input type="password" name="password_confirmation" class="input" required
                            autocomplete="new-password"/>
                    </label>
                </div>

                {{-- Validation --}}
                <h2>Validation</h2>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">Conditions d'utilisation et confidentialité</p>

                        <div>
                            <input
                                type="checkbox"
                                name="accept_cgu"
                                id="accept_cgu"
                                value="1"
                                required
                                @checked(old('accept_cgu'))
                            >

                            <span>
                                J'ai lu et j'accepte les
                                <a href="{{ route('cgu') }}" target="_blank" rel="noopener noreferrer" class="couleur">
                                    conditions générales d'utilisation
                                </a>
                                et reconnais avoir pris connaissance de la
                                <a href="{{ route('confidentialite') }}" target="_blank" rel="noopener noreferrer" class="couleur">
                                    politique de confidentialité
                                </a>.
                            </span>
                        </div>
                    </label>
                </div>

                <span>* Les champs marqués d'une astérisque sont obligatoires</span>

                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;">
                    <span>CRÉER MON COMPTE</span>
                </button>

            </form>

            <p style="margin-top: 4rem;">
                J'ai un compte :
                <a href="{{ route('login') }}" class="couleur">
                    Me connecter
                </a>
            </p>
        </section>
    </main>

@endsection