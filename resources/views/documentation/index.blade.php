@extends('layouts.app')

@section('title', 'Documentations')

@section('content')

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
	<div id="contenu" class="moyen">
		<h1>- Documentation -</h1>
		<div id="search" class="icon-before-ampoule-on ombre_inset centre-element" style="margin-bottom:60px;"><span class="input" placeholder="rechercher dans la documentation" contenteditable>rechercher dans la documentation</span></div>

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
        
        @foreach ($documentations as $documentation)
		<a class="documentation_liste ombre_inset" href="documentation/{{ $documentation->slug }}">
			<div style="width:inherit;">
				<p class="titre" style="font-size: 1.1em;margin-block:0;">{{ $documentation->titre }}</p>
				<p style="font-size: 0.8em;margin-block:0;"><span>Catégorie : </span><span>{{ implode(", ",json_decode($documentation->categories)) }}</span></p>
			</div>
			<div class="picto centre-enfant centre-vertical-enfant" style="width:fit-content">
				<p>&#xe916;&#xe913;</p>
			</div>
		</a>
        @endforeach

	</div>
</div>
@endsection