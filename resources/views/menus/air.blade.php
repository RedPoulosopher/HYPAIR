@extends('menus.#menu')

@section('logo')
    <img id="logo_air" src="/images/logo_air.png" width="120px" alt="logo de l'AIR"/>
    <span>AIR</span>
@endsection

@section('liens')
<a href="/accueil"><li class="iconsax-outline iconsax-home"><span>Accueil</span></li></a>
<a href="/documentations"><li class="iconsax-outline iconsax-document"><span>Documentation</span></li></a>
<a href="/contact"><li class="iconsax-outline iconsax-message"><span>Nous contacter</span></li></a>
@endsection