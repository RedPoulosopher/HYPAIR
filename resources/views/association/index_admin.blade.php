@extends('layouts.app')

@section('titre', 'Associations')

@section('content')
<link rel="stylesheet" type="text/css" href="/css/jstable.css">
<script type="text/javascript" src="/js/jstable.min.js"></script>

<style>

div.table {
    box-sizing: border-box;
    border-radius: 25px;
    margin-top:40px;
    overflow: hidden;
    padding: 13px 18px;
    border: 1px solid var(--gris_1);
    border-color: var(--gris_1);
    transition: border-color 0.1s ease-in-out;
}
div.table:hover {
    border-color: var(--couleur_accentuation);
}
table {
    border-collapse: collapse;
    width:100%;
}
table tr {
    text-align:center;
    color: var(--couleur_police);
    border-bottom: 1px solid transparent;
}
table tbody tr:hover {
    border-bottom: 1px solid var(--gris_1);
}
table th {
    padding: 15px 15px;
    border-bottom: 1px solid var(--gris_1);
}
table td {
    padding: 10px 15px;
}

td.sites {
	font-size: 0.95em;
	color:var(--couleur_police_secondaire);
    display:flex;
    flex-wrap: wrap;
    justify-content: center;
    gap:5px;
}
td.sites span {
	background: var(--gris_1);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}
td.type {
    text-transform: capitalize;
}
</style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Associations -</h1>

		<a href="/association/nouvelle" class="bouton tertiaire icon-security-safe" style="margin:15px;">Créer une association</a>

        <div class="table ombre_petite">
            <table id="index_bureau">
                <thead>
                    <tr>
                        <th width="35%">Nom</th>
                        <th>Sites</th>
                        <th>Type</th>
                        <th width="5%">-</th>
                        <th width="5%">-</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="table ombre_petite">
            <table id="index_comité">
                <thead>
                    <tr>
                        <th width="35%">Nom</th>
                        <th>Sites</th>
                        <th>Type</th>
                        <th width="5%">-</th>
                        <th width="5%">-</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="table ombre_petite">
            <table id="index_liste">
                <thead>
                    <tr>
                        <th width="35%">Nom</th>
                        <th>Sites</th>
                        <th>Type</th>
                        <th width="5%">-</th>
                        <th width="5%">-</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

	</div>
</div>

<script>
    
datatable_options = {
    "perPage" : 10,
    "columns" : [{
            select: [1,2],
            sortable: false,
            searchable: true,
        },{
            select: [3,4],
            sortable: false,
            searchable: false,
        },
    ]
}

let headers = new Headers();
headers.append('X-CSRF-TOKEN', "{!! csrf_token() !!}");
headers.append('Content-Type', 'text/json');

function recuperer_asso(type) {
    let recupAssoObjet = {
        method: 'GET',
        headers: headers,
    };
    var recupAssoRequete = new Request('/associations/index/json?type=' + type, recupAssoObjet);
    
    fetch(recupAssoRequete)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Quelque chose n'a pas fonctionné.")
            }
        })
        .then(data => {
            index_el = document.querySelector("#index_" + type + " tbody");
            data.forEach(data_asso => 
                affichage_data(data_asso, index_el)
            )
            new JSTable("#index_" + type, { ...datatable_options });
        })
        .catch(err => {
            console.log(err.message)
        })
}

var index_el = ""
function affichage_data(asso_data, index_el){
    asso_html = document.createElement('tr')
    asso_html.classList.add("association_liste")

    if(asso_data["type"] == "liste"){
		lien = "https://liste.imt-ne.fr/" + asso_data["uid"] + '-' + asso_data["id"]
    }
    else {
		lien = "https://" + asso_data["uid"] + ".imt-ne.fr/"
    }

	asso_html.innerHTML = 
		'<td><a class="couleur" href="'+ lien +'">' + asso_data["nom"] + '</a></td>' +
		'<td class="sites">' + affichage_sites(asso_data["sites"]) + '</td>' +
        '<td class="type">' + asso_data["type"] + '</td>' +
		'<td><a href="/association/modifier/' + asso_data["id"] + '" class="icon-edit-2" title="modifier"></a></td>' +
		'<td><a href="/association/membres/' + asso_data["id"] + '" class="icon-user-edit" title="membres"></a></td>'

    index_el.appendChild(asso_html)
}

function affichage_sites(sites){
	sites_html = ""
    if(sites !== null){
	    sites = JSON.parse(sites)
	    sites.forEach(site => sites_html+="<span>: " + site + "</span>")
    }

	return sites_html
}

recuperer_asso("comité")
recuperer_asso("bureau")
recuperer_asso("liste")
</script>
@endsection
