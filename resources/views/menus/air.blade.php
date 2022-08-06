@extends('menus.#menu')

@section('logo')
    <img src="/images/logo_air.png" style="width:120px" alt="logo de l'AIR"/>
    <div>AIR</div>
@endsection

@section('liens')
<a href="{{ session('entite_lien') }}/accueil"><li class="iconsax-outline iconsax-home"><span>Accueil</span></li></a>
<a href="{{ session('entite_lien') }}/documentation"><li class="iconsax-outline iconsax-document"><span>Documentation</span></li></a>
<a href="{{ session('entite_lien') }}/projet"><li class="iconsax-outline iconsax-document"><span>Projet</span></li></a>
<a href="{{ session('entite_lien') }}/calendrier"><li class="iconsax-outline iconsax-document"><span>Calendrier</span></li></a>
@endsection
