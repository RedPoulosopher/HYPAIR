@extends('layouts.app-without-sidebar')

@section('titre', 'Post')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/simpleMDE.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/post/formulaire.css') }}" type="text/css">
@endpushonce

@pushonce('start-scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1>{{ $titre ?? 'Créer un post' }}</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue ! Ici vous pourrez créer un post.</p>
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
                        <p class="titre">* Titre :</p>
                        @isset($post)
                            <input type="text" name="titre" class="input" id="titre_doc" required
                                value="{{ $post->titre }}" />
                        @endisset
                        @empty($post)
                            <input type="text" name="titre" class="input" id="titre_doc" required
                                value="{{ old('titre') ?? ($post->titre ?? '') }}" />
                        @endempty
                    </label>
                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Description du post :</p>
                        <p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur"
                                href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le
                                markdown</a> !</p>
                        <p class="description">Pour insérer des emojis, tapez sur Windows + ";" (Windows) ou Contrôle +
                            Commande + Espace (Mac)
                        </p>
                        @isset($post)
                            <textarea name="description_md" id="description_md" class="input"
                                title="Au moins 30 caractères dans la description, et au plus 250" rows="12">{{ $post->description }}</textarea>
                        @endisset
                        @empty($post)
                            <textarea name="description_md" id="description_md" class="input"
                                title="Au moins 30 caractères dans la description, et au plus 250" rows="12">{{ old('description') ?? ($post->description ?? '') }}</textarea>
                        @endempty
                    </label>

                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">Bannière :</p>
                        <input type="file" id="banniere" class="input" name="banniere[]" accept="image/*">
                    </label>
                    {{-- <label for="input_groupe">
                        <p class="titre">Bannière 2 :</p>
                        <p class="description">Choisissez une image pour votre post</p>
                        <input type="file" id="banniere_2" name="banniere[]" accept="image/*">
                    </label>
                    <label for="input_groupe">
                        <p class="titre">Bannière 3 :</p>
                        <p class="description">Choisissez une image pour votre post</p>
                        <input type="file" id="banniere_3" name="banniere[]" accept="image/*">
                    </label> --}}
                </div>



                <details>
                    <summary>
                        <h2>Options avancées</h2>
                    </summary>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="labels">Tags :</p>
                            <p class="description">Séparez les tags par des virgules (e.g. important, soirée, info)</p>
                            @isset($post)
                                <input type="text" name="tags" class="input" id="tags_doc"
                                    value="{{ implode(', ', $post->tags->pluck('name')->toArray()) }}" />
                            @endisset
                            @empty($post)
                                <input type="text" name="tags" class="input" id="tags_doc"
                                    value="{{ old('tags') ?? '' }}" />
                            @endempty
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Rattaché à l'event :</p>
                            <select name="event_id" class="input" spellcheck="false">
                                @isset($post)
                                    @if (empty($post->event_id))
                                        <option value="0" selected>Aucun</option>
                                    @else
                                        <option value="0">Aucun</option>
                                    @endif
                                    @foreach ($events as $event)
                                        @if (!empty($post->event_id) && $post->event_id == $event->id)
                                            <option value="{{ $event->id }}" selected>{{ $event->titre }}</option>
                                        @else
                                            <option value="{{ $event->id }}">{{ $event->titre }}</option>
                                        @endif
                                    @endforeach
                                @endisset
                                @empty($post)
                                    <option value="0" selected>Aucun</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->titre }}</option>
                                    @endforeach
                                @endempty
                            </select>
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Date de publication :</p>
                            @isset($post)
                                <input type="datetime-local" name="date_apparition" class="input" min="01-01-2023"
                                    max="12-31-2099" value="{{ $post->date_apparition }}" />
                            @endisset
                            @empty($post)
                                <input type="datetime-local" name="date_apparition" class="input" min="01-01-2023"
                                    max="12-31-2099" value="{{ old('temps_debut') ?? ($post->date_apparition ?? '') }}" />
                            @endempty
                        </label>
                        <label class="input_groupe">
                            <p class="titre">Date d'expiration :</p>
                            @isset($post)
                                <input type="datetime-local" name="date_expiration" class="input"
                                    value="{{ $post->date_expiration }}" min="2000-01-01" max="2100-12-31" />
                            @endisset
                            @empty($post)
                                <input type="datetime-local" name="date_expiration" class="input"
                                    value="{{ old('temps_fin') ?? ($post->date_expiration ?? '') }}" min="2000-01-01"
                                    max="2100-12-31" />
                            @endempty
                        </label>
                    </div>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Campus</p>
                            <p class="description">Post destiné aux étudiants de quel campus ?</p>
                            <ul id="campus_id">
                                @foreach ($campus as $campus)
                                    <li><input type="checkbox" name="campus_id[]" value="{{ $campus->id }}"
                                            id="campus_id_{{ $campus->id }}"
                                            @checked((isset($post) && in_array($campus->id, $all_post_campus_id)) || (!isset($post) && $campus->id == 1))>{{ Str::ucfirst($campus->label) }}</li>
                                @endforeach
                            </ul>
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Confidentialité</p>
                            <p class="description">Ce post doit-il être caché pour les campus non concernés ?</p>
                            <input type="radio" id="yes" name="confidentialite" value="1"
                                @checked(isset($post) && $post->confidentiel == '1')>
                            <label for="yes">OUI</label><br>
                            <input type="radio" id="no" name="confidentialite" value="0"
                                @checked(!(isset($post) && $post->confidentiel == '1'))>
                            <label for="no">NON</label>
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
                    style="float:right;"><span>{{ isset($post) ? 'MODIFIER' : 'CRÉER' }}</span></button>
            </form>
        </section>
    </main>

@endsection

@pushonce('end-scripts')
    <script>
        var simplemde = new SimpleMDE({
            element: document.getElementById("description_md"),
            toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link",
                "image", "|", "table", "horizontal-rule", "|", "preview"
            ],
            spellChecker: false,
        });
    </script>
@endpushonce
