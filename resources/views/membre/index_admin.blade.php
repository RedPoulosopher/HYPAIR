@extends('layouts.app-without-sidebar')

@section('titre', 'Membres')

@pushonce('styles')
<link rel="stylesheet" type="text/css" href="{{ mix('/css/jstable.css') }}">
<link rel="stylesheet" type="text/css" href="{{ mix('/css/formulaire.css') }}">
<link rel="stylesheet" type="text/css" href="{{ mix('/css/membre/index_admin.css') }}">
@endpushonce

@section('content')
<script type="text/javascript" src="{{ mix('/js/jstable.min.js') }}"></script>


<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestion des Membres</h1>

        <div class="section-content">
            <h2>Ajouter un membre :</h2>
            <form method="POST">
                @csrf
                <div class="groupe card">
                    <label class="input_groupe">
                        <p class="titre">Uid du membre :</p>
                        <p class="description">Rentrez l'uid de la personne ou son adresse étudiante. Faites attention à ce que ce soit bien son adresse, elles ne sont pas toutes construites en prenom.nom !</p>
                        <input id="user_uid" type="text" name="user_uid" required class="input" value="{{old('user_uid') ?? ''}}"/>
                    </label>
                    <div class="input_groupe">
                        <p class="titre">Rôle du membre :</p>
                        {{-- <input type="hidden" id="search_role_input_id" name="role_id"> --}}
                        {{-- <input class="input" id="search_role_input" name="role_name"> --}}
                        <select class="input" id="role-input" name="role_id">                            
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{ ucfirst($role->label) }}</option>
                            @endforeach
                        </select>
                        {{-- <div id="roles">
                            <p style="display:none">aucun rôle ne correspond à cette recherche. Contactez l'AIR pour le rajouter.</p>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach 
                        </div> --}}
                        <p id="droits-role">
                        </p>
                    </div>
                    <div style="display:flex;justify-content: flex-end;">
                        <button type="submit" class="bouton primaire valider_role">VALIDER</span></button>
                    </div>
                </div>
            </form>
        </div>

            {{-- <div id="choix_role">
                <a href="membres" class="bouton secondaire">Membres</a>
                <a href="abonnes" class="bouton secondaire">Abonnés</a>
            </div> --}}
        <div class="section-content">
            <h2>Membres actuels :</h2>
            @if(!is_null($personnes_concernees) && count($personnes_concernees)>0)
                <div class="table card">
                    <table id="index">
                        <thead>
                            <tr>
                                <th width="35%">Prénom</th>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th width="5%">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personnes_concernees as $membre)
                                <tr class="ligne_membre">
                                    <td>{{$membre["prenom"]}}</td>
                                    <td>{{$membre["nom"]}}</td>
                                    <td><span class="role">{{ $membre["label"] }}</span></td>
                                    <td><a 
                                        membre_id="{{ $membre["id"] }}"
                                        role_id="{{ $membre["roles.id"] }}"
                                        user_uid="{{$membre["uid"]}}"
                                        class="icon-edit-2"
                                        title="Modifier"
                                        onclick="afficher_menu_membre(this)"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
	</section>
</main>


{{-- <script type="text/javascript" src="{{ mix('/js/elasticlunr.min.js') }}"></script> --}}
<script>
var roles = {!! json_encode($roles) !!}
var roleInput = document.getElementById('role-input');
var droitDuRole = document.getElementById('droits-role');

roleInput.addEventListener('change', (event) => {
    var id = roleInput.value - 1;

    var text = `${roles[id].gerer_post == 1 ? 'les posts, ' : ''}${roles[id].gerer_evenement == 1 ? 'les évènements, ' : ''}${roles[id].gerer_entite == 1 ? 'l\'entite, ' : ''}${roles[id].gerer_membre == 1 ? 'les membres, ' : ''}${roles[id].gerer_reseau == 1 ? 'les réseaux sociaux, ' : ''}`
    console.log(roles[id].gerer_evenement == 1)
    droitDuRole.innerText = (text.length > 0 ? "Peut gérer " : '') + text.slice(0, -2)//remove last comma
})





// const input_role_nom = document.getElementById('search_role_input');
// const input_role_id = document.getElementById('search_role_input_id');


// //génère l'index
// var index = elasticlunr(function () {
//     this.addField('nom_role');
//     this.setRef('index');
// });

// function remove_accent(str){
//     return str.normalize("NFD").replace(/\p{Diacritic}/gu, "")
// }

// //rentre les données dans l'index
// role_els = document.querySelectorAll('#roles option')
// for(var i = 0; i < role_els.length; i++){
// 	role_id = role_els[i].value
// 	nom_role = role_els[i].innerText
//     nom_role = remove_accent(nom_role)

// 	index.addDoc({"index":i, "nom_role":nom_role, "index_role":role_id})

//     role_els[i].addEventListener('click', function(){
//         input_role_nom.value = this.innerText;
//         input_role_id.value = this.value;
//     })
// }

// input_role_nom.addEventListener("keyup", function(){
// 	a_rechercher = this.value

//     if(a_rechercher==""){
//         for(i=0; i<role_els.length; i++){
//             role_els[i].style.display = "none"
//         }
//     } else {
//         a_rechercher = remove_accent(a_rechercher)
//         rechercher(a_rechercher)
//     }
// })

// aucun_role = document.querySelector('#roles p')
// bouton_valider = document.querySelector('.bouton.primaire.valider_role')
// function rechercher(a_rechercher){
// 	resultats = index.search(a_rechercher, {
// 		expand: true
// 	});
    
//     trier_afficher_resultats(resultats)

//     if(resultats.length==0){
//         aucun_role.style.display = "block"
//         bouton_valider.disabled = true
//     } else {
//         aucun_role.style.display = "none"
//         bouton_valider.disabled = false
//     }
// }

// //affiche les bons résultats pour la recherche
// function trier_afficher_resultats(resultats){
// 	for(i=0; i<role_els.length; i++){
// 		role_els[i].style.display = "none"
// 	}
//     input_role_id.value = resultats[0]["doc"]["index_role"]
// 	for(i=0; i<resultats.length; i++){
// 		index_resultat = resultats[i]["ref"]
// 		role_els[parseInt(index_resultat)].style.display = "block"
// 		role_els[parseInt(index_resultat)].style.order = i+1
// 	}
// }




// datatable_options = {
//     "perPage" : 15,
//     "columns" : [{
//             select: [2],
//             sortable: false,
//             searchable: true,
//         },{
//             select: [3],
//             sortable: false,
//             searchable: false,
//         },
//     ]
// }
// new JSTable("#index", { ...datatable_options });

el_user_uid = document.getElementById("user_uid")
function afficher_menu_membre(ceci){
    membre_id = ceci.getAttribute("membre_id")
    user_uid = ceci.getAttribute("user_uid")
    role_id = ceci.getAttribute("role_id")

    el_user_uid.value = user_uid
    roleInput.querySelector('[value="'+role_id+'"]').selected = true
}
</script>
@endsection