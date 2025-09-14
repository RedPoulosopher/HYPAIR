@extends('layouts.app-without-sidebar')

@section('titre', 'Modifier la description')

@pushonce('styles')
	@vite([
		'resources/css/formulaire.scss',
		'resources/css/documentation.scss',
		'resources/css/simpleMDE.scss',
		'resources/css/entite/modifier_description.scss',
	])
@endpushonce

@pushonce('start-scripts')
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs">Modifier votre entite</h1>
		@if(Session::has('success'))
			<p class="explication">L'entite a été modifiée correctement !</p>
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
				@if (request()->get('creation')!=1)
					<label class="input_groupe">
						<p class="titre">* Nom :</p>
						<input type="text" name="nom" class="input" required value="{{old('nom') ?? $entite->nom ?? ''}}"/>
					</label>
				@endif

				<label class="input_groupe">
					<p class="titre">* Description courte :</p>
					<textarea name="description_courte" class="input" required rows="6">{{old('description_courte') ?? $entite->description_courte ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">Description :</p>
					<p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea name="description_md" id="description_md" class="input" rows="12">{{old('description_md') ?? $entite->description_md ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">* Catégories :</p>
					<p class="description">Séparez les catégories par des virgules (e.g. informatique, réseau, web)</p>
					<input type="text" name="categories" class="input" required value="{{implode(", ", $categories)}}" autocomplete="off"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;">MODIFIER</span></button>
		</form>
	</section>
</main>
@endsection

@pushonce('end-scripts')
<script>
	var simplemde = new SimpleMDE({
		element: document.getElementById("description_md"),
		toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "table", "horizontal-rule", "|", "preview"],
		spellChecker: false,
	});
</script>
@endpushonce