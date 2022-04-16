@extends('menus.#menu')

@section('logo')
    <img src="/images/logo_air.png" width="120px" alt="logo de l'AIR"/>
    <div>AIR</div>
@endsection

@section('liens')
<a href="accueil"><li><span>Accueil</span></li></a>
<a href="actualite"><li><span>Actualité</span></li></a>
<a href="projet"><li><span>Projet</span></li></a>
<a href="documentation"><li><span>Documentation</span></li></a>
<a href="evenement"><li><span>Evènement</span></li></a>
<a href="contact"><li><span>Nous contacter</span></li></a>
<a href="a_propos"><li class="iconsax-outline iconsax-document"><span>A propos</span></li></a>
@endsection
