@extends('layouts.app')

@section('titre', 'Membres')

@section('content')
<link rel="stylesheet" type="text/css" href="/css/jstable.css">
<link rel="stylesheet" type="text/css" href="/css/formulaire.css">
<script type="text/javascript" src="/js/jstable.min.js"></script>

<style>
#choix_role {
    display:flex;
    justify-content:center;
    gap:10px;
    margin-top:25px;
}
div.table {
    box-sizing: border-box;
    border-radius: 25px;
    margin-top:10px;
    overflow: hidden;
    padding: 13px 18px;
    border: 1px solid var(--gris_1);
    background-color: var(--gris_2);
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

td span.role {
	font-size: 0.95em;
	color:var(--couleur_police_secondaire);
	background: var(--gris_1);
	padding: 4px 15px 5px 15px;
	border-radius: 50px;
	text-transform: capitalize;
}
td.type {
    text-transform: capitalize;
}
td a.icon-edit-2 {
    cursor:pointer;
}
</style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- <span class="icon-security-safe" title="page accessible aux administrateurs"></span> Gestion des Membres -</h1>

        <div id="gestion_membre">
            <form method="POST">
                @csrf
                <div class="groupe ombre_petite">
                    <label class="input_groupe">
                        <p class="titre">Uid du membre :</p>
                        <p class="description">Rentrez l'uid de la personne ou son adresse étudiante. Faites attention à ce que ce soit bien son adresse, elles ne sont pas toutes construites en prenom.nom !</p>
                        <input id="user_uid" type="text" name="user_uid" required class="input" value="{{old('user_uid') ?? ''}}"/>
                    </label>
                    <div class="input_groupe">
                        <p class="titre">Rôle du membre :</p>
                        <select class="input" id="select_role" name="role_id">
                            <option disabled selected></option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;justify-content: flex-end;margin-top:15px;">
                        <button type="submit" class="bouton primaire">VALIDER</span></button>
                    </div>
                </div>
            </form>

            <div id="choix_role">
                <a href="entite/membres/{{Request::route('entite_id')}}?type=membre" class="bouton secondaire">Membres</a>
                <a href="entite/membres/{{Request::route('entite_id')}}?type=abonne" class="bouton secondaire">Abonnés</a>
            </div>

            @if(!is_null($personnes_a_responsabilites) && count($personnes_a_responsabilites)>0)
                <div class="table ombre_petite">
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
                            @foreach ($personnes_a_responsabilites as $membre)
                                <tr class="ligne_membre">
                                    <td>{{$membre["prenom"]}}</td>
                                    <td>{{$membre["nom"]}}</td>
                                    <td><span class="role">{{ $membre["label"] }}</span></td>
                                    <td><a membre_id="{{ $membre["id"] }}" role_id="{{ $membre["roles.id"] }}" user_uid="{{$membre["uid"]}}" class="icon-edit-2" title="modifier" onclick="afficher_menu_membre(this)"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
	</div>
</div>


<script>

datatable_options = {
    "perPage" : 15,
    "columns" : [{
            select: [2],
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

el_user_uid = document.getElementById("user_uid")
el_select_role = document.getElementById("select_role")
function afficher_menu_membre(ceci){
    membre_id = ceci.getAttribute("membre_id")
    user_uid = ceci.getAttribute("user_uid")
    role_id = ceci.getAttribute("role_id")

    el_user_uid.value = user_uid
    el_select_role.querySelector('[value="'+role_id+'"]').selected = true
}
</script>
@endsection
