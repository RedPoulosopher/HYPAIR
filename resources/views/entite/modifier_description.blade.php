@extends('layouts.app')

@section('titre', 'Modifier la description')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >
<link rel="stylesheet" href="/css/documentation.css" type="text/css" >

<style id="style_clair"></style>
<style id="style_sombre"></style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs">Modifier votre entite -</h1>
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
			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Description courte :</p>
					<textarea name="description_courte" class="input" required rows="6">{{old('description_courte') ?? $entite->description_courte ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">* Description :</p>
					<p class="description">Pour mettre en forme la description, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea name="description_md" class="input" required rows="12">{{old('description_md') ?? $entite->description_md ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">* Catégories :</p>
					<p class="description">Séparez les catégories par des virgules (e.g. informatique, réseau, web)</p>
					<input type="text" name="categories" class="input" required value="{{old('categories') ?? implode(", ", $categories)}}"/>
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;">MODIFIER</span></button>
		</form>
	</div>
</div>
@endsection
