@extends('layouts.app-without-sidebar')

@section('titre', 'Membres')

@pushonce('styles')
    @vite([
        'resources/css/jstable.scss',
        'resources/css/formulaire.scss',
        'resources/css/documentation-popup.scss',
        'resources/css/membre/index_admin.scss',
    ])
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer un Pôle</h1>

            <div style="margin-bottom: 25px">
                <a href="{{ route("index_pole",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Retour</a>
            </div>

            <div class="section-content">
                <form method="POST" action="">
                    @csrf
                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Nom du pôle :</p>
                            <input id="name" type="text" name="name" required class="input"
                                value="{{ $pole->name ?? old('name') ?? '' }}" autocomplete="off" />
                        </label>
                        <label class="input_groupe">
                            <p class="titre">Priorité d'affichage :</p>
                            <input id="ordre" type="number" name="ordre" required class="input"
                                value="{{ $pole->ordre ?? old('ordre') ?? 0 }}" autocomplete="off" />
                        </label>
                        <div style="display:flex;justify-content: flex-end;">
                            <button type="submit" class="bouton primaire valider_role">VALIDER</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection