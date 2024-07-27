@extends('layouts.app')

@section('titre', $titre)

@section('content')

@vite([
	'resources/css/formulaire.scss',
	'resources/css/simpleMDE.scss',
])
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Créer un nouveau projet</h1>
		@if(Session::has('success'))
			<p class="explication">Merci pour le projet ! Elle est disponible.</p>
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
			<div class="groupe card">
				<span>Cette projet sera accessible via : <span id="lien_projet"></span></span>
				<label class="input_groupe">
					<p class="titre">* Titre :</p>
					<input type="text" name="titre" class="input" id="titre" required value="{{old('titre') ?? $projet->titre ?? ''}}"/>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Confidentialité :</p>
					<select name="confidentialite" class="input" spellcheck="false" required select="{{old('confidentialite') ?? $projet->confidentialite ?? 0}}">
                        @foreach ($confidentialites as $label => $confidentialite)
							<option value="{{ $confidentialite }}">{{ $label }}</option>
						@endforeach
                    </select>
				</label>
			</div>

			<div class="groupe card">
				<label class="input_groupe">
					<p class="titre">* Description courte du projet :</p>
					<p class="description">Pour créer le projet, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea id="description_courte" name="description_courte" title="au moins 100 caractères pour le contenu" rows="13">{{old('description_courte') ?? $projet->description_courte ?? ''}}</textarea>
				</label>
			</div>
			
			<div class="groupe card">
				<label class="input_groupe">
					<p class="titre">*Date de fin du projet :</p>
					<input type="date" name="date_fin" class="input" value="{{old('date_fin') ?? $projet->date_fin ?? '' }}"/>
				</label>
			</div>

            <span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>{{$projet->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
		</form>
	</div>
</div>
<script>
var simplemde = new SimpleMDE({
	element: document.getElementById("description_courte"),
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

pre_url = window.location.origin + "/projet/"
span_lien_doc = document.getElementById("lien_projet")
document.getElementById("titre").addEventListener("keyup",function(){
	slug = string_to_slug(this.value)
	span_lien_doc.innerText = pre_url + slug
})

document.querySelectorAll("select[select]").forEach(function(ceci){
	to_select = ceci.getAttribute("select");
	ceci.querySelector('[value="'+ to_select +'"]').setAttribute("selected","true")
})

</script>
@endsection
