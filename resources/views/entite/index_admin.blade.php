@extends('layouts.app-without-sidebar')

@section('titre', 'Entités')

@pushonce('styles')
    @vite([
        'resources/css/entite/index_admin.scss',
        'resources/css/jstable.scss',
    ])
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Entites</h1>

        {{-- @if (!$est_bureau) --}}
		    <a href="entites/create" class="bouton tertiaire icon-security-safe" id="bouton-creer">Créer une entite</a>
        {{-- @endif --}}

        <div class="section-content">

            <h2>Entites actuelles :</h2>
            <div id="choix_entite">
                @php
                    use App\Enums\EntiteType;
                    $est_bureau = $asso_gerante->type==EntiteType::Bureau;
                    $SU = false;
                    //if(Auth::check() && Auth::user())
                @endphp
                @if ($SU)
                    <a href="?type=independants" class="bouton secondaire">Indépendants</a>
                @endif
                @if ($SU)
                    <a href="?type=bureau" class="bouton secondaire">Bureaux</a>
                @endif
                @if ($est_bureau || $SU)
                    <a href="?type=comité" class="bouton secondaire">Comités & Clubs</a>
                @endif
                @if (true)
                    <a href="?type=liste" class="bouton secondaire">Listes</a>
                @endif
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
                                    <td><a class="couleur" href="{{ $entite->lien_relatif() }}">{{ $entite["name"] }}</a></td>
                                    <td class="sites">
                                        @foreach ($entite->sites()->get()->pluck('label') as $site)
                                            <span class="site">: {{ $site }}</span>
                                        @endforeach
                                    </td>
                                    <td class="type">{{ $entite["type"]->value }}</td>
                                    <td class="meatballs" onclick="javascript:menu_meatballs(this)" entite_uid="{{ $entite["uid"] }}" entite_name="{{ $entite["name"] }}"><div></div><div></div><div></div></td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
                <ul id="menu_meatballs" class="ombre_grande">
                    <li><a id="menu_dashboard" url="/entite/{entite_uid}/dashboard">Dashboard</a></li>
                    <li><a id="menu_dashboard" url="/entite/{entite_uid}/dashboard">Display priority</a></li>
                    <li><a id="menu_dashboard" url="/entite/{entite_uid}/dashboard">Authorisation</a></li>
                    <li><a id="menu_supprimer" url="entites/{entite_uid}/delete" style="color: red;">Supprimer</a></li>
                </ul>
            @endif
            <div id="info" class="popup">
                <div class="documentation card">
                    <div class="contenu_doc" id="contenu_doc">
                        <h2>Attention !</h2>
                        <p id="message">Vous êtes sur le point de supprimer un évènement. </p>
                        <p style='font-style:italic;'>Cette action est irréversible.</p>
                    </div>

                    <div style="display:flex;">
                        <div id="gerer"></div>
                        <p class="bouton secondaire info_bouton ombre_petite" style="margin:15px;">Annuler</p>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
<script type="module">

import "{{ Vite::asset('resources/js/jstable.min.js') }}" 
    
const datatable_options = {
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
</script>

<script>
var dernier_appui = null;
var el_menu_meatballs = document.getElementById("menu_meatballs")
var el_meatballs = document.querySelector(".meatballs")


const taille_x_menu_meatballs = el_menu_meatballs ? el_menu_meatballs.getBoundingClientRect().width : 0
const taille_x_meatballs = el_meatballs ? el_meatballs.getBoundingClientRect().width : 0

if(el_menu_meatballs)
    el_menu_meatballs.style.display = "none"

function menu_meatballs(ceci){
    if(dernier_appui == ceci){
        el_menu_meatballs.style.display = "none"
        dernier_appui = null
    } else {
        el_menu_meatballs.style.display = "block"
        dernier_appui = ceci
    }
    left = ceci.getBoundingClientRect().x
    topp = ceci.getBoundingClientRect().y
    height = ceci.getBoundingClientRect().height

    entite_uid = ceci.getAttribute("entite_uid")
    entite_name = ceci.getAttribute("entite_name")
    for(let element of el_menu_meatballs.querySelectorAll("a")){
        if(element.id!="menu_supprimer"){
            url = element.getAttribute("url")
            element.href = url.replace('{entite_uid}', entite_uid)
        }else{
            url = element.getAttribute("url")
            element.addEventListener("click",e=>{
                document.getElementById("gerer").innerHTML = `
                <form method="POST" action="${url.replace('{entite_uid}', entite_uid)}">
                    @csrf  
                    <button type="submit" name="uid" value=${entite_uid} class="bouton ombre_petite administrateur" style="margin:15px;">Valider</button>
                </form>`;
                document.getElementById("message").innerText += " Voulez-vous vraiment supprimer : « " + entite_name + " » ?";
                document.getElementById("info").classList.add("visible");
            })
        }
    };

    el_menu_meatballs.style.top = topp + 10 + document.documentElement.scrollTop + "px";
    el_menu_meatballs.style.left = left - taille_x_menu_meatballs + taille_x_meatballs + "px";
}

const listener_click_retour = document.querySelectorAll('.info_bouton');

listener_click_retour.forEach((listener_click_retour, index) => {
    listener_click_retour.addEventListener("click", function() {
        document.getElementById("info").classList.remove("visible");
    });
});
</script>
@endsection