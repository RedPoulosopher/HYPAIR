@extends('layouts.app')

@section('title', $title)

@section('content')

<style>
    @media (max-width: 1099.98px) {
		#contenu{
			width:100%;
		}
	}

	@media (min-width: 1100px) {
		#contenu{
			width:800px;
		}
	}
</style>

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
	<div id="contenu">
		<h1>- Créer une nouvelle documentation -</h1>
		@if(Session::has('success'))
			<p class="explication">Merci pour la documentation ! Elle est disponible.</p>
		@else
			<p class="explication">Pour créer de la documentation, <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">utilisez le markdown</a> !</p>
		@endif
		{!! Form::open() !!}
			<div class="champs_conteneur" style="width:100%;">
				@if (!isset($documentation->slug))
					<label class="champs flex border">
						<span class="titre">* Langue :</span>
						<select name="langue" class="input affichage_empty" spellcheck="false" required>
							<option value="fr">Français</option>
							<option value="en">English</option>
						</select>
					</label>
					<label class="champs flex border">
						<span class="titre">* Association :</span>
						<select name="ID_asso" class="input affichage_empty" spellcheck="false" required>
							<option value="0">AIR</option>
						</select>
					</label>
				@endif
				<label class="champs flex border">
					<span class="titre">* Confidentialité :</span>
					<select name="confidentialite" class="input affichage_empty" spellcheck="false" required select="{{$documentation->confidentialite ?? '' }}">
                        <option value="0" selected>0 => public</option>
                        <option value="1">1 => membres de l'association</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4 => responsables & bureau</option>
                        <option value="5">5 => bureau</option>
                        <option value="6">6 => président⸱e⸱s et vice-président⸱e</option>
                        <option value="7">7 => président⸱e⸱s</option>
                        <option value="8">8</option>
                        <option value="9">9 => bureau de l'AIR</option>
                    </select>
				</label>
			</div>
			<div class="champs_conteneur focus_elargi" style="width:100%;" for="titre">
				<label class="champs flex border">
					<span class="titre">* Titre :</span>
					<input type="text" name="titre" class="input affichage_empty" required value="{{$documentation->titre ?? '' }}"/>
				</label>
			</div>
			<div class="champs_conteneur focus_elargi" style="width:100%;" for="contenu">
				<label class="champs">
					<span class="titre">* Contenu de la documentation :</span>
					<textarea name="contenu" class="affichage_empty" pattern=".{100,}" required title="au moins 60 caractères dans la réponse" rows="13">{{$documentation->contenu ?? '' }}</textarea>
				</label>
			</div>
			<div class="champs_conteneur focus_elargi" style="width:100%;" for="categories">
				<label class="champs flex border">
					<span class="titre">* Catégories (séparer par des virgules) :</span>
					<input type="text" name="categories" class="input affichage_empty" required value="{{implode(", ",json_decode($documentation->categories ?? '[]' ))}}"/>
				</label>
			</div>
			<div class="champs_conteneur" style="width:100%;">
				<label class="champs flex border">
					<span class="titre">Mettre en avant ?</span>
					<input type="checkbox" name="mise_en_avant" class="input" {{$documentation->mise_en_avant ?? '' ? "checked" : ""}}/>
				</label>
				<label class="champs flex border">
					<span class="titre">Début de la période de mise en avant :</span>
					<input type="date" name="debut_mise_en_avant" class="input affichage_empty" value="{{$documentation->debut_mise_en_avant ?? '' }}"/>
				</label>
				<label class="champs flex border">
					<span class="titre">Fin de la période de mise en avant :</span>
					<input type="date" name="fin_mise_en_avant" class="input affichage_empty" value="{{$documentation->fin_mise_en_avant ?? '' }}"/>
				</label>
                @error('mise_en_avant')
                {{$message}}
                @enderror
                @error('debut_mise_en_avant')
                {{$message}}
                @enderror
                @error('fin_mise_en_avant')
                {{$message}}
                @enderror
			</div>
			<div class="champs_conteneur focus_elargi" style="width:100%;" for="image1">
				<label class="champs flex border">
					<span class="titre">ajouter une image :</span>
					<input type="file" name="image1" class="input affichage_empty"/>
				</label>
                @error('image1')
                {{$message}}
                @enderror
			</div>
            <span>les champs marqués d'une asterisque sont obligatoires</span>
			<button type="submit" class="bouton primaire icon-after-plus-carre ombre_petite" style="float:right;"><span>{{$documentation->slug ?? '' ? "MODIFIER" : "CRÉER"}}</span></button>
		{!! Form::close() !!}
	</div>

	<script>
		$(".focus_elargi").each(function(){
			$(this).on("click", function(){
				$("[name="+this.getAttribute('for')+"]").focus();
			})
		})

		$(".affichage_empty").each(function(){
			$(this).on("keyup", function(){
				this.parentNode.setAttribute('empty', this.value=='');
			})
		})

		$("select[select]").each(function(){
			to_select = $(this).attr("select");
			console.log(to_select);
			$(this).find('[value="'+ to_select +'"]').attr("selected","true")
		})
	</script>
</div>
@endsection