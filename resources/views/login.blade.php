@extends('layouts.vide')

@section('titre', 'Se connecter')

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>Se connecter</h1>

            <p class="explication">
                Bienvenue ! Remplissez le formulaire ci-dessous pour accéder à votre compte.
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                    <div class="erreurs">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Identification --}}
                <h2>Identification</h2>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">Adresse e-mail :</p>
                        <input
                            type="email"
                            name="email"
                            class="input"
                            required
                            autofocus
                            autocomplete="username"
                            value="{{ old('email') }}"
                        />
                    </label>

                    <label class="input_groupe">
                        <p class="titre">Mot de passe :</p>
                        <input
                            type="password"
                            name="password"
                            class="input"
                            required
                            autocomplete="current-password"
                        />
                    </label>
                </div>

                <p>
                    <a href="" class="couleur">
                        Mot de passe oublié ?
                    </a>
                </p>

                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;">
                    <span>SE CONNECTER</span>
                </button>

            </form>

            <p style="margin-top: 4rem;">
                Vous n'avez pas encore de compte ?
                <a href="{{ route('register') }}" class="couleur">
                    Créer un compte
                </a>
            </p>

        </section>
    </main>

@endsection