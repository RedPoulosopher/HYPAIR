@extends('layouts.app-without-sidebar')

@section('titre', 'Logotype')

@section('content')

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/documentation.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/entite/modifier_logotype.css') }}" type="text/css" >
@endpushonce


<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Ajouter un logotype</h1>

		<div class="section-content">
			@if(Session::has('success'))
				<p class="explication">Le logo a été modifié !</p>
			@endif
			<form method="POST" enctype="multipart/form-data">
				@csrf
				@if ($errors->any())
					<div class="erreurs">
						@foreach ($errors->all() as $error)
							<div>{{ $error }}</div>
						@endforeach
					</div>
				@endif
				<div class="groupe card">
					<label class="input_groupe">
					<p class="titre">* Logo :</p>
					<p class="description">Soit un svg de moins de 70ko, soit une image de plus de 512px par côté.</p>
						<label id="file-upload">
							<input type="file" name="logo" class="input" id="original_input" {{$creation==1 ? "required" : ""}} accept="image/*">
							Sélectionnez un fichier
						</label>
						<span id="filename">Aucun fichier sélectionné</span>
					</label>
				</div>
					
				<span>* les champs marqués d'une astérisque sont obligatoires</span>
				<button type="submit" class="bouton primaire" style="float:right;"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
			</form>
		</div>
	</section>
</main>

<script>
	var input = document.getElementById('original_input');
	var label = document.getElementById('filename');

	
	input.addEventListener( 'change', function( e )
	{
		labelVal = label.innerHTML;
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName )
			label.innerHTML = "File name : " + fileName;
		else
			label.innerHTML = labelVal;
	});

</script>

@endsection
