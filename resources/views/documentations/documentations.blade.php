@extends('layouts.app')

@section('title','documentations - AIR')

@section('content')

<style>
	@media (max-width: 767.98px) {
		#contenu{
			width:100%;
		}
	}

	@media (min-width: 768px) {
		#contenu{
			width:800px;
		}
	}
</style>

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
	<div id="contenu">
		<h1>- Documentation -</h1>
		<div id="search" class="icon-before-ampoule ombre_inset centre-element" style="margin-bottom:60px;"><span class="input" placeholder="rechercher dans la documentation" contenteditable>rechercher dans la documentation</span></div>

		<script>
			const ele = document.getElementById('search').firstChild;
			const placeholder = ele.getAttribute('placeholder');

			ele.addEventListener('focus', function(e) {
					const value = e.target.innerHTML;
					value === placeholder && (e.target.innerHTML = '');
			});

			ele.addEventListener('blur', function(e) {
					const value = e.target.innerHTML;
					value === '' && (e.target.innerHTML = placeholder);
			});
		</script>

		<a class="documentation_liste ombre_inset" href="documentation">
			<div style="width:inherit;">
				<p class="titre" style="font-size: 1.1em;margin-block:0;">Comment se connecter au réseau de la MEUD</p>
				<p style="font-size: 0.8em;margin-block:0;"><span>Catégorie : </span><span>informatique, réseau, MEUD</span></p>
			</div>
			<div class="picto centre-enfant centre-vertical-enfant" style="width:fit-content">
				<p>&#xe901;</p>
				<p>&#xe902;</p>
			</div>
		</a>


		<a class="documentation_liste ombre_inset" href="documentation">
			<div style="width:inherit;">
				<p class="titre" style="font-size: 1.1em;margin-block:0;">Comment se connecter au réseau de la MEUD</p>
				<p style="font-size: 0.8em;margin-block:0;"><span>Catégorie : </span><span>informatique, réseau, MEUD</span></p>
			</div>
			<div class="picto centre-enfant centre-vertical-enfant" style="width:fit-content">
				<p>&#xe901;</p>
				<p>&#xe902;</p>
			</div>
		</a>


		<a class="documentation_liste ombre_inset" href="documentation">
			<div style="width:inherit;">
				<p class="titre" style="font-size: 1.1em;margin-block:0;">Comment se connecter au réseau de la MEUD</p>
				<p style="font-size: 0.8em;margin-block:0;"><span>Catégorie : </span><span>informatique, réseau, MEUD</span></p>
			</div>
			<div class="picto centre-enfant centre-vertical-enfant" style="width:fit-content">
				<p>&#xe901;</p>
				<p>&#xe902;</p>
			</div>
		</a>

	</div>
</div>
	
@endsection