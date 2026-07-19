@extends('layouts.app-without-sidebar')

@if ($creation)
    @section('titre', 'Créer une entité')
@else
    @section('titre', 'Personalisé l\'entité')
@endif

@pushonce('styles')
    @vite([
        'resources/css/formulaire.scss',
        'resources/css/documentation.scss',
		'resources/css/simpleMDE.scss',
    ])
@endpushonce

@pushonce('start-scripts')
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpushonce




@php
	use Carbon\Carbon;
	$annee_actuelle = Carbon::now()->format("Y");
@endphp



@section('content')
    <style id="style_clair"></style>
    <style id="style_sombre"></style>

    <main id="main-content">
        <section>
            <h1><span class="icon-security-safe" title="page réservée aux administrateurs"></span>
            @if ($creation)
                Créer une nouvelle entité
            @else
                Personalisé l'entité
            @endif
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
                        <input type="text" style="display: none" name="entite_courante_uid" required value="{{ $entite_courante_uid ?? ($entite->uid ?? '') }}"/>
                        <input type="number" style="display: none" name="creation" required value="{{ $creation }}"/>
                        <label class="input_groupe">
                            <p class="titre">* Nom :</p>
                            <input type="text" name="name" class="input" required
                                value="{{ old('name') ?? ($entite->name ?? '') }}" autocomplete="off"/>
                        </label>

                        @if ($creation)
                        <label class="input_groupe">
                            <p class="titre">* Uid :</p>
                            <input type="text" name="uid" class="input" required
                                value="{{ old('uid') ?? ($entite->uid ?? '') }}" autocomplete="off"/>
                        </label>
                        @else
                            <input style="display: none" style="text" name="uid" class="input" required value="{{ old('uid') ?? ($entite->uid ?? '') }}" autocomplete="off"/>
                        @endif

                        @if ($creation)
                            <label class="input_groupe" style="display: none;">
                                <p class="titre">* Ratachement :</p>
                                <select name="parent_uid" class="input" spellcheck="false" required
                                    select="{{ old('parent_uid') ?? ($entite_parant_uid ?? '') }}">
                                    <option selected disabled="disabled"></option>
                                    @foreach ($entites as $entite_)
                                        <option value="{{ $entite_->uid }}">{{  $entite_->name }}</option>
                                    @endforeach
                                    <option value="independant">Independant</option>
                                </select>
                            </label>
                        @endif

                        @if ($creation)
                            <label class="input_groupe">
                                <p class="titre">* Type :</p>
                                <select name="type" class="input" spellcheck="false" required
                                    select="{{ old('type') ?? ($entite->type ?? '') }}">
                                    <option selected disabled="disabled"></option>
                                    @foreach ($entite_types as $case)
                                        <option value="{{ $case->value }}">{{  $case->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        @endif
                    </div>
                    <div class="groupe card">
						<label class="input_groupe">
							<p class="titre">Logo :</p>
							<p class="description">Soit un svg de moins de 70ko, soit une image de plus de 512px par côté.</p>
							<label id="file-upload">
								<input type="file" name="logo" class="input" id="original_input" accept="image/*">
								Sélectionnez un fichier
							</label>
							<span id="filename">Aucun fichier sélectionné</span>
						</label>

						<label class="input_groupe">
							<p class="titre">Description courte :</p>
							<textarea name="short_description" class="input" rows="6">{{old('short_description') ?? $entite->short_description ?? ''}}</textarea>
						</label>

						<label class="input_groupe">
							<p class="titre">Description :</p>
							<p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
							<textarea name="description" id="description" class="input" rows="12">{{old('description') ?? $entite->description ?? ''}}</textarea>
						</label>
					</div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">* Catégories :</p>
                            <p class="description">Séparez les catégories par des virgules (e.g. informatique, réseau, web)</p>
                            <input type="text" name="tags" class="input" value="{{old('tags') ?? $entite->tags ?? ""}}" required autocomplete="off"/>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Sites :</p>
                            <p class="description">Les sites sur lesquels l'entite est présente. Ctrl + clic pour sélectionner plusieurs sites.</p>

                            <select name="sites[]" class="input" spellcheck="false" multiple required style="overflow-y: auto;">
                                @php
                                    $selectedSites = [];
                                    if(isset($entite)){
                                        $selectedSites = old('sites') ?? ($entite->sites->pluck('id')->toArray() ?? []);
                                    }else{
                                        $selectedSites = old('sites') ?? [];
                                    }
                                @endphp

                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}"
                                        {{ in_array($site->id, $selectedSites) ? 'selected' : '' }}>
                                        {{ $site->label }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Couleur principale sur thème clair :</p>
                            <input type="color" name="color_1" class="input" required id="color_1"value="{{old('color_1') ?? $entite->color_1 ?? ''}}">
                        </label>

                        <label class="input_groupe">
                            <p class="titre">* Couleur principale sur thème sombre :</p>
                            <input type="color" name="color_2" class="input" required id="color_2" value="{{old('color_2') ?? $entite->color_2 ?? ''}}">
                        </label>
                    </div>

                    <div class="groupe card">
                        <label class="input_groupe">
                            <p class="titre">* Année de création :</p>
                            <input type="number" name="annee_creation" class="input" required min="1980" max="{{ $annee_actuelle }}" value="{{old('annee_creation') ?? $entite->annee_creation ?? $annee_actuelle}}"/>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">email :</p>
                            <p class="description">Certaines entites possèdent un compte email fourni par la DISI.</p>
                            <input autocomplete="off" type="text" name="email" class="input" value="{{old('email') ?? $entite->email ?? ''}}"/>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">Alias :</p>
                            <p class="description">Certaines entites ont un alias, qui rédirige les emails vers les membres indiqués à la DISI.</p>
                            <input autocomplete="off" type="text" name="alias" class="input" value="{{old('alias') ?? $entite->alias ?? ''}}"/>
                        </label>

                        <label class="input_groupe">
                            <p class="titre">Visible :</p>

                            <label>
                                <input type="checkbox" name="visible" value="1"
                                    {{ old('visible', $entite->visible ?? true) ? 'checked' : '' }}>
                                L’entité est visible
                            </label>
                        </label>
                    </div>

                    <span>* Les champs marqués d'une astérisque sont obligatoires</span>
                    <button type="submit" class="bouton primaire ombre_petite"
                        style="float:right;"><span>{{ $creation ? 'CRÉER' : 'MODIFIER' }}</span></button>
                </form>
            </div>
        </section>
    </main>
@endsection




@pushonce('end-scripts')
<script>
	var simplemde = new SimpleMDE({
		element: document.getElementById("description"),
		toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "table", "horizontal-rule", "|", "preview"],
		spellChecker: false,
	});

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