@extends('layouts.app')

@section('titre', 'Documentations')

@section('content')

<link rel="stylesheet" href="/css/documentation.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- Documentation -</h1>
		
		<div id="search" class="ombre_inset centre-element" style="margin-bottom:60px;"><span class="input" placeholder="rechercher dans la documentation" id="search_input" contenteditable>rechercher dans la documentation</span></div>

		@if($gerer_documentation)
		<a href="/documentation/nouvelle" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Créer une documentation</a>
		@endif

		<script>
			const ele = document.getElementById('search').firstChild;
			const placeholder = ele.getAttribute('placeholder');

			ele.addEventListener('focus', function(e) {
					const value = e.target.innerHTML;
					value === placeholder && (e.target.innerHTML = '');
			});

			ele.addEventListener('blur', function(e) {
					const value = e.target.innerHTML;
					value === '' && (e.target.innerHTML = placeholder);
			});
		</script>
        
        <div id="index_docs">
		</div>

	</div>
</div>

<script type="text/javascript" src="/js/elasticlunr.js"></script>
<script>
var index = elasticlunr(function () {
    this.addField('titre');
    this.addField('description');
    this.setRef('id');
});


let headers = new Headers();
headers.append('X-CSRF-TOKEN', "{!! csrf_token() !!}");
headers.append('Content-Type', 'text/json');

function recuperer_doc() {
    let recupDocObjet = {
        method: 'GET',
        headers: headers,
    };
    var recupDocRequete = new Request('/documentation/index/json', recupDocObjet);
    
    fetch(recupDocRequete)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Quelque chose n'a pas fonctionné.")
            }
        })
        .then(data => {
			data.forEach(function(doc_data){
				affichage_data(doc_data);
				index.addDoc({"id":doc_data["id"], "titre":doc_data["titre"], "description":doc_data["description"]})
			})
        })
        .catch(err => {
            console.log(err.message)
        })
}

index_docs = document.getElementById("index_docs");
function affichage_data(doc_data){
    doc_html = document.createElement('a')
	doc_html.innerHTML = 
		'<a class="documentation_liste" href="documentation/' + doc_data["slug"] + '">' +
			'<div style="width:inherit;">' +
				'<p class="titre">' + doc_data["titre"] + '</p>' +
				'<p class="description">' + doc_data["contenu_md"] + '</p>' +
				'<div class="categories">' +
					affichage_categories(doc_data["categories"])
				'</div>' +
			'</div>' +
		'</a>'

	index_docs.appendChild(doc_html)
}
function affichage_categories(categories){
	categories_html = ""
	categories = JSON.parse(categories)
	categories.forEach(categorie => categories_html+="<span>#" + categorie + "</span>")
	
	return categories_html
}

recuperer_doc()

var _changeInterval = null;
document.getElementById("search_input").addEventListener("keyup", function(){
	a_rechercher = this.innerText
	
	clearInterval(_changeInterval)
    _changeInterval = setInterval(function() {

		resultat = index.search(a_rechercher, {
			fields: {
				titre: {boost: 2},
				description: {boost: 1}
			},
			expand: true
		});
		console.log(resultat)

        clearInterval(_changeInterval)
    }, 500);
})
</script>
@endsection