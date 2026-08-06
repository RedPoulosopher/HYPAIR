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
            <h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer un Rôle</h1>

		    <div style="margin-bottom: 25px">
                <a href="{{ route("index_role",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Retour</a>
		        <a href="{{ route("index_pole",[$entite->uid]) }}" class="bouton tertiaire" id="bouton-creer">Gestionnaire des pôles</a>
            </div>

            <div class="section-content">
                <form method="POST" action="">
                    @csrf
                    @if ($errors->any())
                        <div class="erreurs">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Nom du rôle :</p>
                            <input id="name" type="text" name="name" required class="input"
                                value="{{ $role->name ?? old('name') ?? '' }}" autocomplete="off"/>
                        </label>
                        <label class="input_groupe">
                            <p class="titre">Pôle :</p>
                            <select name="pole_uid" class="input" spellcheck="false" select="{{ $role->pole_uid ?? old('pole_uid') ?? '' }}">
                                <option value="">Sans Pôle</option>
                                @foreach ($poles as $pole)
                                    <option value="{{ $pole->uid }}">{{ $pole->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="input_groupe">
                            <p class="titre">Priorité d'affichage :</p>
                            <input id="ordre" type="number" name="ordre" required class="input"
                                value="{{ $role->ordre ?? old('ordre') ?? 0 }}" autocomplete="off" />
                        </label>
                        @if (!is_null($perms) && count($perms) > 0)
                            <h2 style="margin-top: 15px">Permison:</h2>
                            <table id="index">
                                <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th>ID</th>
                                        <th>Activer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perms as $perm)
                                        <tr class="ligne_membre">
                                        <td>{{ $perm->label() }}</td>

                                        <td>
                                            <span class="role">
                                                {{ $perm->name }} ({{ $perm->value }})
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <label class="checkbox-wrapper">
                                                <input
                                                    type="checkbox"
                                                    name="perms[]"
                                                    value="{{ $perm->value }}"
                                                    class="checkbox-permission"
                                                    @checked(
                                                        old('perms')
                                                        ? in_array($perm->value, old('perms'))
                                                        : (isset($role) && $role->permissions->contains('perm', $perm->value)))
                                                >
                                                <span class="checkbox-custom"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <div style="display:flex;justify-content: flex-end;">
                            <button type="submit" class="bouton primaire valider_role">VALIDER</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection