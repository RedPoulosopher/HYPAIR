@extends('layouts.app')

@section('titre', $titre)

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >
<link rel="stylesheet" href="/css/simpleMDE.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Ajouter une nouvelle avancée -</h1>
		@if(Session::has('success'))
			<p class="explication">Merci pour le travail ! Il est consultable.</p>
		@endif
		<form method="POST">
			@csrf
			@if ($errors->any())
				<div class="erreurs">
					@foreach ($errors->all() as $error)
						<div>{{ $error }}</div>
					@endforeach
				</div>
			@endif
			<div class="groupe ombre_petite">
				<span>Cette avancée sera accessible via : <span id="lien_doc"></span></span>
				<label class="input_groupe">
					<p class="titre">* Titre :</p>
					<input type="text" name="titre" class="input" id="titre_doc" required value="{{old('titre') ?? $avancee->titre ?? ''}}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">* Contenu de l'avancée :</p>
					<p class="description">Pour créer de l'avancéee, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea id="description_md"  name="description_md" title="au moins 100 caractères pour le contenu" rows="13">{{old('desciption_md') ?? $avancee->desciption_md ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">Ajouter des images :</p>
					<p class="description">En informatique, une image de 200ko prend autant de place que 30 000 mots. Nous limitons la taille des images à 1920*1080 pixels, et à 300ko. Privilégiez le SVG si possible. <a target="_blank" class="couleur" href="https://air.imt-ne.fr/documentation/guide-images">guide sur les images</a></p>
					<input type="file" name="image" class="input" value="{{ old('image')?? $avancee->image ?? '' }}"/>
				</label>

				<label class="input_groupe">
					<p class="titre">Ajouter des fichiers :</p>
					<input type="file" name="file" class="input" value="{{ old('file')?? $avancee->file ?? '' }}"/>
				</label>
			</div>
            <span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" name="submit" class="bouton primaire" style="float:right;"><span>{{$avancee->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
		</form>
	</div>
</div>
<script>
var simplemde = new SimpleMDE({
	element: document.getElementById("contenu_md"),
	toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "table", "horizontal-rule", "|", "preview"],
	spellChecker: false,
});

function string_to_slug(str) {
	str = str.replace(/^\s+|\s+$/g, ""); // trim
	str = str.toLowerCase();

	// remove accents, swap ñ for n, etc
	var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
	var to = "aaaaaaeeeeiiiioooouuuunc------";

	for (var i = 0, l = from.length; i < l; i++) {
		str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
	}

	str = str
		.replace(/[^a-z0-9 -]/g, "") // remove invalid chars
		.replace(/\s+/g, "-") // collapse whitespace and replace by -
		.replace(/-+/g, "-") // collapse dashes
		.replace(/^-+/, "") // trim - from start of text
		.replace(/-+$/, ""); // trim - from end of text

	return str;
}

pre_url = window.location.origin + '/projet/<project name>/avancee/'
span_lien_doc = document.getElementById("lien_doc")
document.getElementById("titre_doc").addEventListener("keyup",function(){
	slug = string_to_slug(this.value)
	span_lien_doc.innerText = pre_url + slug
})

document.querySelectorAll("select[select]").forEach(function(ceci){
	to_select = ceci.getAttribute("select");
	ceci.querySelector('[value="'+ to_select +'"]').setAttribute("selected","true")
})

</script>
@endsection
