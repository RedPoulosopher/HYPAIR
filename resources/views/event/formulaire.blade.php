@extends('layouts.app-without-sidebar')

@section('titre', 'Évènements')

@pushonce('styles')
    @vite([
        'resources/css/simpleMDE.scss',
        'resources/css/formulaire.scss',
        'resources/css/evenements/formulaire.scss',
    ])
@endpushonce

@pushonce('start-scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpushonce

@section('content')

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>{{ isset($event) ? 'Editer un évènement' : 'Créer un évènement' }}</h1>
            @if (Session::has('success'))
                <p class="explication">Bienvenue ! Ici vous pourrez créer un évènement.</p>
            @endif
            <form method="POST"  enctype="multipart/form-data">
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
                                value="{{ old('title') ?? ($event->title ?? '') }}" />
                    </label>
                </div>

                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Début de l'évènement :</p>
                        <input type="datetime-local" name="started_at" class="input" min="01-01-2023"
                            max="12-31-2099"
                            value="{{ old('started_at') ?? ($event->started_at ?? '') }}" required/>
                    </label>
                    <label class="input_groupe">
                        <p class="titre">* Fin de l'évènement:</p>
                        <input type="datetime-local" name="ended_at" class="input"
                            value="{{ old('ended_at') ?? ($event->ended_at ?? '') }}" min="2000-01-01"
                            max="2100-12-31" required/>
                    </label>
                </div>


                @php
                    $reflection = new ReflectionEnum(\App\Enums\ValidationStatusEvent::class);
                    $valEnum = $reflection->getConstants();
                @endphp
                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">* Status de validation :</p>
                        @php
                            $VS = old('validation_status') ?? ($event->validation_status ?? '')
                        @endphp
                        <select name="validation_status" class="input" spellcheck="false" required>
                            @foreach ($valEnum as $case)
                                <option value="{{ $case }}" @selected($VS === $case)>{{  $case }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>


                <details>
                    <summary>
                        <h2>Options avancées</h2>
                    </summary>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Lieu :</p>
                            @isset($event)
                                <input type="text" name="lieu" class="input" id="lieu_evenement"
                                    value="{{ $event->lieu }}" />
                            @endisset
                            @empty($event)
                                <input type="text" name="lieu" class="input" id="lieu_evenement"
                                    value="{{ old('lieu') ?? ($event->lieu ?? '') }}" />
                            @endempty
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Description de l'évènement :</p>
                            <p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur"
                                    href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le
                                    markdown</a> !</p>
                            <p class="description">Pour insérer des emojis, tapez sur Windows + ";" (Windows) ou Contrôle +
                                Commande + Espace (Mac)
                            </p>
                            <p class="description">Au moins 10 caractères dans la description, et au plus 2500</p>
                                <textarea name="description_md" id="description_md" class="input"
                                    rows="12">{{ old('description_md') ?? ($event->description ?? '') }}</textarea>
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
                                    @checked((isset($event) && $event->entite_collab()->get()->pluck('uid')->contains($entite->uid)))>
                                        {{$entite->name }}
                                </li>                                            
                                @endforeach
                            </ul>
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

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Tags :</p>
                            <p class="description">Séparez les tags par des virgules (e.g. important, soirée, info)</p>
                            <input type="text" name="tags" autocomplete="off" class="input" id="tags_doc"
                                value="{{ old('tags') ?? ( $event->tags ?? '') }}" />
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Visible pour tous :</p>
                            <p class="description"></p>
                            <select name="visibility_all" class="input" spellcheck="false" select="{{ old('visibility_all') ?? ($event->visibility_all ?? '') }}">
                                @if(isset($event))
                                    <option value="1" selected>Oui</option>
                                    <option value="0">Non</option>
                                @else
                                    <option value="1">Oui</option>
                                    <option value="0" selected>Non</option>
                                @endif
                            </select>
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Sous inscription :</p>
                            <p class="description"></p>
                            <select name="sub_registrations" class="input" spellcheck="false" select="{{ old('sub_registrations') ?? ($event->sub_registrations ?? '') }}">
                                @if(isset($event))
                                    <option value="1" selected>Oui</option>
                                    <option value="0">Non</option>
                                @else
                                    <option value="1">Oui</option>
                                    <option value="0" selected>Non</option>
                                @endif
                            </select>
                        </label>
                    </div>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Date de publication :</p>
                            @isset($event)
                                <input type="datetime-local" name="published_at" class="input" min="01-01-2023"
                                    max="12-31-2099" value="{{ $event->published_at }}" />
                            @endisset
                            @empty($event)
                                <input type="datetime-local" name="published_at" class="input" min="01-01-2023"
                                    max="12-31-2099" />
                            @endempty
                        </label>
                    </div>


                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Nombre maximum de participants :</p>
                            @isset($event)
                                <input type="number" name="max_participants" class="input"
                                    id="max_participants_evenement" value="{{ $event->max_participants }}"
                                    min="0" />
                            @endisset
                            @empty($event)
                                <input type="number" name="max_participants" class="input"
                                    id="max_participants_evenement"
                                    value="{{ old('max_participants') ?? ($event->max_participants ?? '') }}"
                                    min="0" />
                            @endempty
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">Campus</p>
                            <p class="description">Évènement destiné aux étudiants de quel campus ?</p>
                            <ul id="campus_id">
                                @foreach ($sites as $site)
                                    <li>
                                        <input type="checkbox" name="campus_id[]" value="{{ $site->id }}" id="campus_id_{{ $site->id }}"
                                        
                                            @checked((isset($event) && $event->sites()->pluck('id')->contains($site->id)) ||
                                            (!isset($event) && (old('campus_id') ? in_array($site->id, old('campus_id')) : in_array($site->id, ($my_entite->sites->pluck('id')->toArray() ?? [])) )))/>
                                                    {{ Str::ucfirst($site->label) }}
                                    </li>
                                @endforeach
                            </ul>
                        </label>
                    </div>
                    
                </details>


                <span>* Les champs marqués d'une astérisque sont obligatoires</span>
                <button type="submit" class="bouton primaire ombre_petite"
                    style="float:right;"><span>{{ isset($event) ? 'MODIFIER' : 'CRÉER' }}</span></button>
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