@extends('layouts.app-without-sidebar')

@section('titre', 'Créer une entité')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/documentation.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/entite/creer.css') }}" type="text/css">
@endpushonce

@section('content')
    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span> Créer une nouvelle entite
            </h1>

            <div class="section-content">
                @if (Session::has('success'))
                    <p class="explication">L'entite a été créée correctement ! Elle est disponible.</p>
                @endif
                <form method="POST" enctype="multipart/form-data">
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
                            <p class="titre">* Nom :</p>
                            <input type="text" name="nom" class="input" required
                                value="{{ old('nom') ?? ($entite->nom ?? '') }}" />
                        </label>
                        <label class="input_groupe">
                            <p class="titre">* Uid :</p>
                            <input type="text" name="uid" class="input" required
                                value="{{ old('uid') ?? ($entite->uid ?? '') }}" />
                        </label>

                        @if(!$est_bureau)
                        <label class="input_groupe">
                            <p class="titre">* Ratachement :</p>
                            <select name="ratachement" class="input" spellcheck="false" required
                                select="{{ old('ratachement') ?? ($entite->ratachement ?? '') }}">
                                <option selected disabled="disabled"></option>
                                <option value="bda">BDA</option>
                                <option value="bde">BDE</option>
                                <option value="bdh">BDH</option>
                                <option value="bds">BDS</option>
                                <option value="independant">Independant</option>
                            </select>
                        </label>
                        @endif

                        <label class="input_groupe">
                            <p class="titre">* Type :</p>
                            <select name="type" class="input" spellcheck="false" required
                                select="{{ old('type') ?? ($entite->type ?? '') }}">
                                <option selected disabled="disabled"></option>
                                @if(!$est_bureau)
                                    <option value="association">Association</option>
                                    <option value="bureau">Bureau</option>
                                @endif
                                <option value="comité">Comité</option>
                                <option value="fakeliste">Fake liste</option>
                                <option value="liste">Liste</option>
                            </select>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Sites :</p>
                            <p class="description">Les sites sur lesquels l'entite est présente. Ctrl + clic pour
                                sélectionner plusieurs sites.</p>
                            <select name="sites[]" class="input" spellcheck="false" multiple required
                                select_mutliple="{{ old('sites') ?? ($entite->sites ?? '') }}" style="overflow-y: auto;">
                                <option value="douai">Douai</option>
                                <option value="dunkerque">Dunkerque</option>
                                <option value="lille">Lille</option>
                                <option value="valenciennes">Valenciennes</option>
                                <option value="alençon">Alençon</option>
                            </select>
                        </label>
                    </div>

                    <span>* les champs marqués d'une astérisque sont obligatoires</span>
                    <button type="submit" class="bouton primaire" style="float:right;"><span>SUIVANT</span></button>
                </form>
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll("select[select]").forEach(function(ceci) {
            to_select = ceci.getAttribute("select");
            ceci.querySelector('[value="' + to_select + '"]').setAttribute("selected", "true")
        })
        document.querySelectorAll("select[select_multiple]").forEach(function(ceci) {
            to_select = JSON.parse(ceci.getAttribute("select_multiple"))
            to_select.forEach(function(a_selectionner) {
                ceci.querySelector('[value="' + a_selectionner + '"]').setAttribute("selected", "true")
            })
        })
    </script>
@endsection
