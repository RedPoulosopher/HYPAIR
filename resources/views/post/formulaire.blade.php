@extends('layouts.app-without-sidebar')

@section('titre', 'Post')

@pushonce('styles')
    @vite([
        'resources/css/simpleMDE.scss',
        'resources/css/formulaire.scss',
        'resources/css/post/formulaire.scss',
    ])
@endpushonce

@pushonce('start-scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpushonce




@section('content')

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>{{ isset($post) ? 'Editer un post' : 'Créer un post' }}</h1>
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
                            <input type="text" autocomplete="off" name="title" class="input" id="titre_doc" required
                                value="{{ old('title') ?? ($post->title ?? '') }}" />
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
                        <p class="description">Au moins 10 caractères dans la description, et au plus 2500</p>
                            <textarea name="description_md" id="description_md" class="input"
                                rows="12">{{ old('description_md') ?? ($post->content ?? '') }}</textarea>
                    </label>
                </div>


                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">Bannière :</p>
                        <p class="description"></p>
                        <label id="file-upload">
                            <input type="file" name="banniere" class="input" id="original_input" accept="image/*">
                            Sélectionnez un fichier
                        </label>
                        <span id="filename">Aucun fichier sélectionné</span>
                    </label>
                </div>


                <details>
                    <summary>
                        <h2>Options avancées</h2>
                    </summary>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Tags :</p>
                            <p class="description">Séparez les tags par des virgules (e.g. important, soirée, info)</p>
                            <input type="text" name="tags" autocomplete="off" class="input" id="tags_doc"
                                value="{{ old('tags') ?? ( $post->tags ?? '') }}" />
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Rattaché à l'event :</p>
                            <select name="event_uid" class="input" spellcheck="false">
                                @isset($post)
                                    @if (empty($post->event_uid))
                                        <option value="0" selected>Aucun</option>
                                    @else
                                        <option value="0">Aucun</option>
                                    @endif
                                    @foreach ($events as $event)
                                        @if (!empty($post->event_uid) && $post->event_uid == $event->uid)
                                            <option value="{{ $event->uid }}" selected>{{ $event->title }}</option>
                                        @else
                                            <option value="{{ $event->uid }}">{{ $event->title }}</option>
                                        @endif
                                    @endforeach
                                @endisset
                                @empty($post)
                                    <option value="0" selected>Aucun</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->uid }}">{{ $event->title }}</option>
                                    @endforeach
                                @endempty
                            </select>
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre"> Collaboration </p>
                            <p class="description"> En collaboration avec quelle autre association ?</p>                        
                            <ul name="entite_collab_id" spellcheck="false">
                                @foreach ($entites as $entite)                                    
                                <li>    
                                    <input type="checkbox" name="entite_collab_id[]" value="{{ $entite->uid }}"
                                    @checked((isset($post) && $post->entite_collab()->get()->pluck('uid')->contains($entite->uid)))>
                                        {{$entite->name }}
                                </li>                                            
                                @endforeach
                            </ul>
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Date de publication :</p>
                            <input type="datetime-local" name="published_at" class="input" min="01-01-2023"
                                max="12-31-2099"
                                value="{{ old('published_at') ?? ($post->published_at ?? '') }}" />
                        </label>
                        <label class="input_groupe">
                            <p class="titre">Date d'expiration :</p>
                            <input type="datetime-local" name="archived_at" class="input"
                                value="{{ old('archived_at') ?? ($post->archived_at ?? '') }}" min="2000-01-01"
                                max="2100-12-31" />
                        </label>
                    </div>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Campus</p>
                            <p class="description">Post destiné aux étudiants de quel campus ?</p>
                            <ul id="campus_id">
                                @foreach ($sites as $site)
                                    <li>
                                        <input type="checkbox" name="campus_id[]" value="{{ $site->id }}" id="campus_id_{{ $site->id }}"
                                            @checked((isset($post) && in_array($site->id, array_column($post->json_data['acces_details']['sites'] ?? [],'id') ?? [])) ||
                                            (!isset($post) && (old('campus_id') ? in_array($site->id, old('campus_id')) : in_array($site->id, ($my_entite->sites->pluck('id')->toArray() ?? [])) )))/>
                                                    {{ Str::ucfirst($site->label) }}
                                    </li>
                                @endforeach
                            </ul>
                        </label>
                    </div>
                </details>

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

        var input = document.getElementById('original_input');
        var label = document.getElementById('filename');

        input.addEventListener( 'change', function( e )
        {
            labelVal = label.innerHTML;
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.innerHTML = "File name : " + fileName;
            else
                label.innerHTML = labelVal;
        });
    </script>
@endpushonce