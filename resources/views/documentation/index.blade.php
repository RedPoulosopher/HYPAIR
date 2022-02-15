@extends('layouts.app')

@section('titre', 'Documentations')

@section('content')

<link rel="stylesheet" href="css/documentation.css" type="text/css" >

<div id="wrapper">
	<div id="contenu" class="petit">
		<h1>- Documentation -</h1>
		
		<div id="search" class="ombre_inset centre-element" style="margin-bottom:60px;"><span class="input" placeholder="rechercher dans la documentation" contenteditable>rechercher dans la documentation</span></div>

		@if($gerer_documentation)
		<a href="/documentation/nouvelle" class="bouton tertiaire ombre_petite administrateur" style="margin:15px;">Créer une documentation</a>
		@endif

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
		<a class="documentation_liste" href="documentation/{{ $documentation->slug }}">
			<div style="width:inherit;">
				<p class="titre">{{ $documentation->titre }}</p>
				<p class="description">{{ substr($documentation->contenu_md, 0, 350) }}</p>
				<div class="categories">
					@foreach(json_decode($documentation->categories) as $categorie)
						<span>#{{$categorie}}</span>
					@endforeach
				</div>
			</div>
		</a>
        @endforeach

	</div>
</div>
@endsection