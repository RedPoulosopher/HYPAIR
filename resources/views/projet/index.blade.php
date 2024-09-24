@extends('layouts.app')

@section('titre', 'Projets')

@section('content')

@vite('resources/css/documentation.scss')

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>Projet</h1>
		
		<div id="search" class="ombre_inset centre-element icon-search-normal-1" style="margin-bottom:60px;"><span class="input" placeholder="Rechercher un projet" id="search_input" contenteditable>Rechercher un projet</span></div>

		@if($gerer_projet)
		<a href="projet/nouveau" class="bouton tertiaire ombre_petite icon-security-safe" style="margin:15px;">Créer un projet</a>
		@endif
        
        <div id="index_docs">

			@foreach ($projets as $projet)
			<a class="documentation_liste" href="projet/{{ $projet->slug }}">
				<div>
					@if ($projet->confidentialite > 0)
					<span class="icon-security" title="projet privée"></span>
					@endif
					<span class="titre">{{ $projet->titre }}</span>
					<p class="contenu_md">{{ $projet->description_courte }}</p>
				</div>
			</a>
			@endforeach

		</div>
	</div>
</div>

<script type="module">
// Import not tested
import { elasticlunr } from "{{ Vite::asset('resources/js/elasticlunr.min.js') }}"

const champ_recherche = document.getElementById('search_input');
const placeholder = champ_recherche.getAttribute('placeholder');

champ_recherche.addEventListener('focus', function(e) {
	const value = e.target.innerHTML;
	value === placeholder && (e.target.innerHTML = '');
});

champ_recherche.addEventListener('blur', function(e) {
	const value = e.target.innerHTML;
	value === '' && (e.target.innerHTML = placeholder);
});



//génère l'index
var index = elasticlunr(function () {
    this.addField('titre');
    this.addField('description');
    this.setRef('index');
});



//rentre les données dans l'index
doc_inv_rech_els = document.querySelectorAll('.documentation_liste[visibilite="1"]') //les docs visibles que par la recherche
doc_inv_els = document.querySelectorAll('.documentation_liste[visibilite="2"]') //les docs invisibles
doc_els = document.querySelectorAll('.documentation_liste:not([visibilite="2"])')
for(var i = 0; i < doc_els.length; i++){
	doc_el = doc_els[i]

	titre = doc_el.querySelector(".titre").innerText

	index.addDoc({"index":i, "titre":titre})
}
@if(!$gerer_projet)
for(var i = 0; i < doc_inv_rech_els.length; i++){
	doc_inv_rech_els[i].style.display = "none"
}
for(var i = 0; i < doc_inv_els.length; i++){
	doc_inv_els[i].style.display = "none"
}
@endif

//recherche si y'a pas eu d'input dans les dernieres 500ms
var _changeInterval = null;
document.getElementById("search_input").addEventListener("keyup", function(){
	a_rechercher = this.innerText

	clearInterval(_changeInterval)
	_changeInterval = setInterval(function() {

		if(a_rechercher==""){
			for(i=0; i<doc_els.length; i++){
				doc_els[i].style.display = "block"
			}
			for(var i = 0; i < doc_inv_rech_els.length; i++){
				doc_inv_rech_els[i].style.display = "none"
			}
		} else {
			rechercher(a_rechercher)
		}

		history.replaceState({"recherche": a_rechercher}, '', '')
		
		clearInterval(_changeInterval)
	}, 500);
})

function rechercher(a_rechercher){
	resultat = index.search(a_rechercher, {
		fields: {
			titre: {boost: 2},
			description: {boost: 1},
			categories: {boost: 4},
		},
		expand: true
	});
	trier_afficher_resultats(resultat)
}

//affiche les bons résultats pour la recherche
function trier_afficher_resultats(resultats){
	for(i=0; i<doc_els.length; i++){
		doc_els[i].style.display = "none"
	}
	for(i=0; i<resultats.length; i++){
		index_resultat = resultats[i]["ref"]
		doc_els[parseInt(index_resultat)].style.display = "block"
		doc_els[parseInt(index_resultat)].style.order = i+1
	}
}


//restore la recherche à partir de l'historique
if(history.state != null){
	a_rechercher = history.state["recherche"]
	if(typeof a_rechercher !== 'undefined' && a_rechercher != ""){
		rechercher(a_rechercher)
		champ_recherche.innerText = a_rechercher
	}
}
</script>
@endsection