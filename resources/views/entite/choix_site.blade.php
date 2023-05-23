@extends('layouts.vide')

@section('titre', 'Choix du site')

@section('content')

<style>
.conteneur_boutons {
	margin-top:40px;
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap:20px;
}
.gros_bouton {
	width:200px;
	height:200px;
	border: 1px solid var(--gris_1);
	border-radius: 15px;
	display: flex;
	justify-content: center;
	align-items: center;
	box-sizing: border-box;
    padding: 10px;
	text-align: center;
	background: var(--gris_3);
	transition: background 0.15s ease-in-out;
}
.gros_bouton:hover {
	background: var(--gris_2);
}
</style>

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>Index associatif HypAIR</h1>

		<div class="conteneur_boutons">
			<a class="gros_bouton" href="entites/douai">Douai (Classes préparatoires)</a>
			<a class="gros_bouton" href="entites/lille">Lille (prépa intégrée)</a>
		</div>
	</div>
</div>

<script>
if(window.location.search[0] == "?"){
	tmp = localStorage.getItem('defaut_entites_index_site')
	if(tmp !== undefined){
		window.location.replace('/entites/' + tmp)
	}
}
</script>
@endsection
