@extends('menus.#menu')

@section('liens')
<a href="{{ session('entite_lien') }}/accueil"><li class="iconsax-outline iconsax-home"><span>Accueil</span></li></a>
<a href="{{ session('entite_lien') }}/documentation"><li class="iconsax-outline iconsax-document"><span>Documentation</span></li></a>
<a href="{{ session('entite_lien') }}/calendrier"><li class="iconsax-outline iconsax-document"><span>Calendrier</span></li></a>
<a href="{{ session('entite_lien') }}/entite/evenement"><li><span>Évènements</span></li></a>
<a href="{{ session('entite_lien') }}/projet"><li class="iconsax-outline iconsax-document"><span>Projet</span></li></a>
@endsection
