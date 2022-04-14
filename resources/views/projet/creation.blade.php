@extends('layouts.app')

@section('titre', "nouveau projet")

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="moyen">
		<h1>- Créer un nouveau projet -</h1>
		@if(Session::has('success'))
			<p class="explication">Merci pour le projet ! Il est disponible.</p>
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
				<span>Ce projet sera accessible via : <span id="lien_doc"></span></span>
				<label class="input_groupe">
					<p class="titre">* Titre :</p>
					<input type="text" name="titre" class="input" id="titre_doc" required value="{{old('titre') ?? $projet->titre ?? ''}}"/>
				</label>
				
				<label class="input_groupe">
					<p class="titre">* Confidentialité :</p>
					<select name="confidentialite" class="input" spellcheck="false" required select="{{old('confidentialite') ?? $projet->confidentialite ?? ''}}">
						<option value="0" selected>public</option>
                        <option value="2">abonné·e·s</option>
						<option value="5">membres</option>
						<option value="10">responsables & bureau</option>
						<option value="15">bureau</option>
						<option value="20">président·e & vice-président·e</option>
                    </select>
				</label>

				<label class="input_groupe">
					<p class="titre">* Chef du projet :</p>
					<select name="confidentialite" class="input" spellcheck="false" required select="{{old('chef_projet') ?? $projet->chef_projet ?? ''}}">
						<?php 
						$asso = session('association_id');
						$membre = Auth::user()->membres()->where("id", $asso);
						for($i=0; $i<= count($membre) ; $i++)
							{
    							echo "<option value=".$membre[$i].">".$i."</option>";
							}
						?> 
     <option name="years"> </option>	
                    </select>
				</label>


			</div>

			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Description courte du projet :</p>
					<textarea name="description" pattern=".{0,1000}" required title="au moins 0 caractères dans la description, et au plus 1000" rows="15">{{old('description_courte') ?? $projet->description_courte ?? ''}}</textarea>
				</label>
			</div>
			
			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">Date de la fin du projet :</p>
					<p class="description">La date de la fin du projet pourra être modifier.</p>
					<input type="date" name="date_fin" class="input" value="{{old('date_fin') ?? $projet->fin_mise_en_avant ?? '' }}" min="2000-01-01" max="2022-12-31"/>
				</label>
			</div>

            <span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire ombre_petite" style="float:right;"><span>{{$projet->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
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

pre_url = window.location.origin + "/projet/"
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