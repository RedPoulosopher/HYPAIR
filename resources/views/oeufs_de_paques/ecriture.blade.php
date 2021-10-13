@extends('layouts.vide')

@section('titre','histoire')

@section('content')
<style>
@media (max-width: 767.98px) {
		#contenu{
		width:100%;
		}
}

@media (min-width: 768px) {
		#contenu{
		width:500px;
		}
}
</style>
<div id="contenu" class="petit" style="font-family: monospace; font-size:1.3em">
    <p class="ecrire" delai="0" vitesse="10" texte="coucou !"></p>
    <p class="ecrire" delai="1200" vitesse="10" texte="comment ça va ?"></p>
    <p class="ecrire" delai="3000" vitesse="23" variance="4" texte="Nous ça va très bien, il fait super beau ici ! Il paraît que dans le nord c'est rare, donc on en profite un max. Quand tu liras ces lignes, il fera peut être moche, je ne sais pas."></p>
    <p class="ecrire" delai="11500" vitesse="23" variance="4" texte="Développer ce site ne fut pas une tache facile. On dirait pas, mais il est hyper complet ! Meme mon poto Zuck n'aurait pas fait aussi bien. En plus on respecte la vie privée des gens et tout, nous sommes de bonnes personnes au fond. C'est pas parce qu'on moite qu'il faut nous juger."></p>
</div>

<script>
elements = document.getElementsByClassName("ecrire")

for(var elem of elements){
    delai = parseInt(elem.getAttribute("delai"))
    vitesse = parseInt(elem.getAttribute("vitesse"))
    variance = parseInt(elem.getAttribute("variance"))
    if (Number.isNaN(variance)) variance = 0;
    console.log(variance)
    texte = elem.getAttribute("texte")
    ecire_texte(elem, texte, delai, vitesse, variance);
}

function ecire_texte(elem, texte, delai, vitesse, variance){
    let texte_pos = 0;
    function x(){
        if(texte_pos < texte.length){
            elem.innerHTML += texte.charAt(texte_pos);
            texte_pos++;
            vitesse_variance = vitesse + Math.round(Math.random()*variance)
            setTimeout(x, Math.round(1000/vitesse_variance))
        }
    }
    setTimeout(function(){x()}, delai)
}
</script>
@endsection