@extends('layouts.app-without-sidebar')

@section('titre', 'Admin')

@section('content')
    @pushonce('styles')
        {{-- <link rel="stylesheet" href="{{ mix('/css/authentification.css') }}" type="text/css" /> --}}
        <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    @endpushonce


    <div id="main-content" class="petit">
        <section>
            <h1>Authentification pour les Admins</h1>
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
                        <p class="mdp">Mot de passe :</p>
                        <input type="password" name="mdp" class="input" id="mdp" required />
                    </label>
                </div>

                <p>L'authentification en tant qu'admin vous permet de voir tous les éléments du site.</p>
                <br>
                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;"><span>VALIDER</span></button>
            </form>
        </section>
    </div>


@endsection
