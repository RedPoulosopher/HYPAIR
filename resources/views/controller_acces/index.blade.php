@extends('layouts.app-without-sidebar')

@section('titre', 'Contrôleurs d\'accès')

@pushonce('styles')
@vite([
'resources/css/entite/index_gestion.scss',
'resources/css/formulaire.scss',
])
@endpushonce

@section('content')

<main id="main-content">
    <section>

    <h1>
        <span class="icon-security-safe" title="page accessible aux administrateurs"></span>
        Gestion des contrôleurs d'accès
    </h1>

    @if (session('success'))
        <p class="explication">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="erreurs">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="section-content">

        <div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
            <a href="{{ route('controller-acces.create') }}"
               class="bouton tertiaire ombre_petite">
                <i class="fa-solid fa-plus"></i>
                Ajouter un contrôleur
            </a>
        </div>

        <h2>Contrôleurs d'accès :</h2>

        @if ($badgeuses->count() > 0)

            <div class="table card">
                <table id="index">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Token</th>
                            <th>Créé le</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($badgeuses as $controller)
                            <tr class="ligne_membre">

                                <td>
                                    {{ $controller->name }}
                                </td>

                                <td>
                                    <code>{{ $controller->token }}</code>
                                </td>

                                <td>
                                    {{ $controller->created_at?->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    <div style="display:flex; gap:10px; align-items:center;">

                                        <a href=""
                                           class="icon-edit-2"
                                           title="Modifier">
                                        </a>

                                        <form method="POST"
                                              action=""
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce contrôleur d’accès ?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="bouton_action warning"
                                                    title="Supprimer"
                                                    style="border:0; background:none;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <p class="no-content">
                Aucun contrôleur d'accès pour le moment.
            </p>

        @endif

    </div>

</section>

</main>

@endsection
