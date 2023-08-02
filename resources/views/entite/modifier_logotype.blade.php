@extends('layouts.app')

@section('titre', 'Logotype')

@section('content')

@pushonce('styles')
<link rel="stylesheet" href="/css/entite/modifier_logotype.css" type="text/css" >
@endpushonce


<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Ajouter un logotype</h1>
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
			<div class="groupe ombre_petite">
				<label class="input_groupe">
					<p class="titre">* Logotype :</p>
					<p class="description">Soit un svg de moins de 70ko, soit un png de ratio 1 et de plus de 512px.</p>
					<input type="file" name="logo" class="input" {{$creation==1 ? "required" : ""}} accept=".png">
				</label>
			</div>
				
			<span>* les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="float:right;"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
		</form>
	</section>
</main>

@endsection
