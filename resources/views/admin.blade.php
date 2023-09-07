@extends('layouts.app-without-sidebar')

@section('titre', 'Connexion')

@section('content')
    @pushonce('styles')
        <link rel="stylesheet" href="{{ mix('/css/authentification.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    @endpushonce


    <div id="main-content" class="petit">
        <section>
            <h1>Authentification</h1>
            <form method="POST">
                @csrf
                @if ($errors->any())
                    <div class="erreurs">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                @foreach ($users as $user)
                    <div class="groupe card">
                        <label class="input_groupe flex">
                            <input type="radio" name="utilisateur" value={{ $user->id }} class="input"
                                @if ($user->id == 1) checked @endif />
                            <p><strong> {{ $user->prenom }} {{ $user->nom }}</strong>{{ $user->resume() }}</p>
                        </label>
                    </div>
                @endforeach

                <p>Vous pouvez rajouter des utilisateurs dans votre base de données locale pour effectuer plus de tests.</p>
                <br>
                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;"><span>VALIDER</span></button>
            </form>
        </section>
    </div>


    @endsection@extends('name')
