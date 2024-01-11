@extends('layouts.app-without-sidebar')

@section('titre', 'Entités')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('/css/entite/index_admin.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/jstable.css') }}">
@endpushonce

@section('content')
<script type="text/javascript" src="{{ mix('/js/jstable.min.js') }}"></script>

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Entites</h1>

        {{-- @if (!$est_bureau) --}}
		    <a href="../entite/nouvelle" class="bouton tertiaire icon-security-safe" id="bouton-creer">Créer une entite</a>
        {{-- @endif --}}

        <div class="section-content">

            <h2>Entites actuelles :</h2>
            <div id="choix_entite">
                @if (!$est_bureau)
                    <a href="?type=bureau" class="bouton secondaire">Bureaux</a>
                @endif
                <a href="?type=comité" class="bouton secondaire">Comités</a>
                <a href="?type=liste" class="bouton secondaire">Listes</a>
            </div>
    
            @if(isset($entites_dependantes) && count($entites_dependantes)>0)
                <div class="table card">
                    <table id="index">
                        <thead>
                            <tr>
                                <th width="35%">Nom</th>
                                <th>Sites</th>
                                <th>Type</th>
                                <th width="5%">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entites_dependantes as $entite)
                                <tr class="ligne_entite">
                                    <td><a class="couleur" href="{{ $entite->lien_relatif() }}">{{ $entite["nom"] }}</a></td>
                                    <td class="sites">
                                        @foreach ($entite->sites()->get()->pluck('label') as $site)
                                            <span class="site">: {{ $site }}</span>
                                        @endforeach
                                    </td>
                                    <td class="type">{{ $entite["type"]->value }}</td>
                                    <td class="meatballs" onclick="javascript:menu_meatballs(this)" entite_id="{{ $entite["id"] }}"><div></div><div></div><div></div></td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
                <ul id="menu_meatballs" class="ombre_grande">
                    <li><a id="menu_modifier" href="" url="../entite/{entite_id}/modifier/informations">Modifier les infos</a></li>
                    <li><a id="menu_modifier" href="" url="../entite/{entite_id}/modifier/description">Modifier la description</a></li>
                    <li><a id="menu_modifier_logo" href="" url="../entite/{entite_id}/logotype">Modifier le logo</a></li>
                    <li><a id="menu_modifier_logo" href="" url="../entite/{entite_id}/couleur">Modifier la couleur</a></li>
                    <li><a id="menu_membres" href="" url="../entite/{entite_id}/membres">Gérer les membres</a></li>
                    <li><a id="menu_membres" href="" url="../entite/{entite_id}/evenement">Gérer les évènements</a></li>
                </ul>
            @endif
        </div>
    </section>
</main>

<script>
    
datatable_options = {
    "perPage" : 15,
    "columns" : [{
            select: [1,2],
            sortable: false,
            searchable: true,
        },{
            select: [3],
            sortable: false,
            searchable: false,
        },
    ]
}
new JSTable("#index", { ...datatable_options });

dernier_appuie = null;
el_menu_meatballs = document.getElementById("menu_meatballs")
taille_x_menu_meatballs = el_menu_meatballs.getBoundingClientRect().width
taille_x_meatballs = document.querySelector(".meatballs").getBoundingClientRect().width
el_menu_meatballs.style.display = "none"
function menu_meatballs(ceci){
    if(dernier_appuie == ceci){
        el_menu_meatballs.style.display = "none"
        dernier_appuie = null
    } else {
        el_menu_meatballs.style.display = "block"
        dernier_appuie = ceci
    }
    left = ceci.getBoundingClientRect().x
    topp = ceci.getBoundingClientRect().y
    height = ceci.getBoundingClientRect().height

    entite_id = ceci.getAttribute("entite_id")
    for(let element of el_menu_meatballs.querySelectorAll("a")){
        url = element.getAttribute("url")
        element.href = url.replace('{entite_id}', entite_id)
    };

    el_menu_meatballs.style.top = topp + 10 + document.documentElement.scrollTop + "px";
    el_menu_meatballs.style.left = left - taille_x_menu_meatballs + taille_x_meatballs + "px";
}
</script>
@endsection
