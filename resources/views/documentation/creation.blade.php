@extends('layouts.app')

@section('titre', $titre)

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1>- Créer une nouvelle documentation -</h1>
		@if(Session::has('success'))
			<p class="explication">Merci pour la documentation ! Elle est disponible.</p>
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
				<span>Cette documentation sera accessible via : <span id="lien_doc"></span></span>
				<label class="input_groupe">
					<p class="titre">* Titre :</p>
					<input type="text" name="titre" class="input" id="titre_doc" required value="{{old('titre') ?? $documentation->titre ?? ''}}"/>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Langue :</p>
					<select name="langue" class="input" spellcheck="false" required select="{{old('langue') ?? $documentation->langue ?? ''}}">
						<option value="fr">Français</option>
						<option value="en">English</option>
					</select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Confidentialité :</p>
					<select name="confidentialite" class="input" spellcheck="false" required select="{{old('confidentialite') ?? $documentation->confidentialite ?? ''}}">
                        <option value="0" selected>public</option>
                        <option value="1">membres de l'association</option>
                        <option value="4">responsables & bureau</option>
                        <option value="5">bureau</option>
                        <option value="6">président⸱e⸱s et vice-président⸱e</option>
                    </select>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Visibilité :</p>
					<select name="visibilite" class="input" spellcheck="false" required select="{{old('visibilite') ?? $documentation->visibilite ?? '' }}">
                        <option value="0" selected>affichée dans l'index</option>
                        <option value="1">affichée lors d'une recherche, mais pas dans l'index</option>
                        <option value="2">pas affichée (pour compléter les autres doc)</option>
                    </select>
				</label>

				<label class="input_groupe">
					<p class="titre">Dérive de :</p>
					<p class="description">Si votre documentation est une traduction, ou s'il s'agit d'un complément à une autre documentation, il faut l'indiquer ici</p>
					<select name="derive_de" class="input" spellcheck="false" select="{{old('derive_de') ??$documentation->derive_de ?? ''}}">
                        <option value="" selected></option>
						@foreach ($docs_existantes as $doc)
							@if($doc["id"] != Request::route('id'))
							<option value="{{ $doc["id"] }}">{{ $doc["titre"] }}</option>
							@endif
						@endforeach
                    </select>
				</label>
			</div>

			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Description de la documentation pour la recherche :</p>
					<textarea name="description" pattern=".{30,250}" required title="au moins 30 caractères dans la description, et au plus 250" rows="5">{{old('description') ?? $documentation->description ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">* Contenu de la documentation :</p>
					<p class="description">Pour créer de la documentation, <a target="_blank" class="couleur" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
					<textarea name="contenu_md" pattern=".{100,}" required title="au moins 100 caractères pour le contenu" rows="13">{{old('contenu_md') ?? $documentation->contenu_md ?? ''}}</textarea>
				</label>

				<label class="input_groupe">
					<p class="titre">Ajouter des image :</p>
					<p class="description">En informatique, une image de 200ko prend autant de place que 30 000 mots. Nous limitons la taille des images à 1920*1080 pixels, et à 300ko. Privilégiez le SVG si possible. <a target="_blank" class="couleur" href="https://air.imt-ne.fr/documentation/guide-images">guide sur les images</a></p>
					<input type="file" name="image1" class="input"/>
				</label>

				<label class="input_groupe">
					<p class="titre">* Catégories (séparer par des virgules) :</p>
					<input type="text" name="categories" class="input" required value="{{old('categories') ?? implode(", ",json_decode($documentation->categories ?? '[]'))}}"/>
				</label>
			</div>
			
			<div class="groupe ombre_petite">
				<label class="input_groupe flex">
					<p class="titre">Mettre en avant manuellement ?</p>
					<input type="checkbox" name="mise_en_avant" class="input" {{old('mise_en_avant') ?? $documentation->mise_en_avant ?? '' ? "checked" : ""}}/>
				</label>
				<label class="input_groupe">
					<p class="titre">Début de la période de mise en avant automatique :</p>
					<p class="description">l'année n'a aucune importance puisque la mise en avant de la documentation sera répétée chaque année.</p>
					<input type="date" name="debut_mise_en_avant" class="input" value="{{old('debut_mise_en_avant') ?? $documentation->debut_mise_en_avant ?? '' }}" min="2000-01-01" max="2000-12-31"/>
				</label>
				<label class="input_groupe">
					<p class="titre">Fin de la période de mise en avant automatique :</p>
					<input type="date" name="fin_mise_en_avant" class="input" value="{{old('fin_mise_en_avant') ?? $documentation->fin_mise_en_avant ?? '' }}" min="2000-01-01" max="2000-12-31"/>
				</label>
			</div>

            <span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire icon-after-plus-carre ombre_petite" style="float:right;"><span>{{$documentation->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
		</form>
	</div>
</div>

<script>
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

pre_url = window.location.origin + "/documentation/"
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