@extends('layouts.app')

@section('titre', 'Associations')

@section('content')
<style>
.nom {
	font-weight: 500;
	font-size: 1.1em;
	margin-block: 0;
}

.sites {
	font-size: 0.95em;
	color:var(--couleur_police_secondaire);
    display:flex;
    flex-wrap: wrap;
    justify-content: center;
    gap:5px;
}
.sites span {
	background: var(--gris_1);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}

div.table {
    border: 1px solid var(--gris_1);
    border-top-color: var(--couleur_accentuation);
    box-sizing: border-box;
    border-radius: 15px;
    margin-top:40px;
    overflow: hidden;
    background-color: var(--gris_2);
}
table {
    border-collapse: collapse;
    width:100%;
}
table tr {
    text-align:center;
    color: var(--couleur_police);
    transition: color 0.1s ease-in-out;
    /* border-bottom: 1px solid var(--gris_1); */
}
table > tr:hover {
    color: var(--couleur_police_secondaire);
}
table th {
    padding: 15px 15px;
    border-bottom: 1px solid var(--gris_1);
}
table td {
    padding: 10px 15px;
}
</style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Associations -</h1>

		<a href="/association/nouvelle" class="bouton tertiaire" style="margin:15px;">Créer une association</a>

        <div class="table ombre_petite">
            <table id="index_assos">
                <tr>
                    <th width="35%">Nom</th>
                    <th>Sites</th>
                    <th>Type</th>
                    <th width="5%">-</th>
                </tr>
            </table>
        </div>

        <div class="table ombre_petite">
            <table id="index_listes">
                <tr>
                    <th width="35%">Nom</th>
                    <th>Sites</th>
                    <th>Type</th>
                    <th width="5%">-</th>
                </tr>
            </table>
        </div>

	</div>
</div>

<script>
let headers = new Headers();
headers.append('X-CSRF-TOKEN', "{!! csrf_token() !!}");
headers.append('Content-Type', 'text/json');

function recuperer_doc(type) {
    let recupAssoObjet = {
        method: 'GET',
        headers: headers,
    };
    var recupAssoRequete = new Request('/association/index/json?type=' + type, recupAssoObjet);
    
    fetch(recupAssoRequete)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Quelque chose n'a pas fonctionné.")
            }
        })
        .then(data => {
            data.forEach(data_asso => 
                affichage_data(data_asso)
            )
        })
        .catch(err => {
            console.log(err.message)
        })
}
index_assos = document.getElementById("index_assos");
index_listes = document.getElementById("index_listes");
function affichage_data(asso_data){
    asso_html = document.createElement('tr')
    asso_html.classList.add("association_liste")

    if(asso_data["type"] == "liste"){
		lien = "https://liste.imt-ne.fr/" + asso_data["uid"] + '-' + asso_data["id"]
        index_el = index_listes
    }
    else {
		lien = "https://" + asso_data["uid"] + ".imt-ne.fr/"
        index_el = index_assos
    }

	asso_html.innerHTML = 
		'<td><a class="couleur" href="'+ lien +'">' + asso_data["nom"] + '</a></td>' +
		'<td class="sites">' + affichage_sites(asso_data["sites"]) + '</td>' +
        '<td>' + asso_data["type"] + '</td>' +
		'<td><a href="/association/modifier/' + asso_data["id"] + '" class="icon-edit-2" title="modifier"></a></td>'

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

recuperer_doc("reste")
recuperer_doc("liste")
</script>
@endsection
