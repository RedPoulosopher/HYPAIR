@extends('layouts.app-without-sidebar')

@section('titre', isset($controller) ? 'Modifier un contrôleur' : 'Ajouter un contrôleur')

@pushonce('styles')
@vite([
'resources/css/formulaire.scss',
])
@endpushonce

@section('content')

<main id="main-content">
    <section>


    <h1>
        <span class="icon-security-safe" title="page réservée aux administrateurs"></span>
        {{ isset($controller) ? 'Modifier un contrôleur d\'accès' : 'Ajouter un contrôleur d\'accès' }}
    </h1>

    @if ($errors->any())
        <div class="erreurs">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ isset($controller)
                ? ""
                : route('controller-acces.create') }}">

        @csrf

        @isset($controller)
            @method('PUT')
        @endisset

        <div class="groupe card">

            <label class="input_groupe">
                <p class="titre">* Nom du contrôleur :</p>

                <input
                    type="text"
                    name="name"
                    class="input"
                    autocomplete="off"
                    required
                    value="{{ old('name', $controller->name ?? '') }}"
                    placeholder="Ex : Entrée bâtiment A"
                />
            </label>

        </div>

        <div class="groupe card">

            <label class="input_groupe">
                <p class="titre">* Token :</p>

                <p class="description">
                    Le token permet au contrôleur physique de s'authentifier auprès de l'application.
                </p>

                <div style="display:flex; gap:10px; align-items:center;">

                    <input
                        type="text"
                        name="token"
                        id="token"
                        class="input"
                        autocomplete="off"
                        required
                        value="{{ old('token', $controller->token ?? '') }}"
                    />

                    <button
                        type="button"
                        id="generer-token"
                        class="bouton secondaire">
                        Générer
                    </button>

                </div>
            </label>

        </div>

        <div class="groupe card">

        <label class="input_groupe">

            <p class="titre">Entités autorisées :</p>

            <p class="description">
                Sélectionnez les entités qui peuvent utiliser ce contrôleur d'accès.
            </p>

            @php
                $entitesSelectionnees = isset($controller)
                    ? $controller->entites->pluck('uid')->toArray()
                    : old('entite_uid', []);
            @endphp

            @if ($entites->count() > 0)

                <ul id="entites-acces">

                    @foreach ($entites as $entite)

                        <li>

                            <label>
                                <input
                                    type="checkbox"
                                    name="entite_uid[]"
                                    value="{{ $entite->uid }}"
                                    @checked(
                                        in_array(
                                            $entite->uid,
                                            $entitesSelectionnees
                                        )
                                    )
                                >

                                {{ $entite->name }}

                            </label>

                        </li>

                    @endforeach

                </ul>

            @else

                <p class="no-content">
                    Aucune entité disponible.
                </p>

            @endif

        </label>

        </div>


        <span>
            * Les champs marqués d'une astérisque sont obligatoires
        </span>

        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">

            <a href="{{ route('controller-acces.index') }}"
               class="bouton secondaire">
                ANNULER
            </a>

            <button type="submit"
                    class="bouton primaire ombre_petite">

                {{ isset($controller) ? 'MODIFIER' : 'AJOUTER' }}

            </button>

        </div>

    </form>

</section>


</main>

@endsection

@pushonce('end-scripts')

<script>
    document.getElementById('generer-token').addEventListener('click', function () {

        const array = new Uint8Array(32);
        crypto.getRandomValues(array);

        const token = Array.from(array)
            .map(byte => byte.toString(16).padStart(2, '0'))
            .join('');

        document.getElementById('token').value = token;
    });
</script>

@endpushonce
