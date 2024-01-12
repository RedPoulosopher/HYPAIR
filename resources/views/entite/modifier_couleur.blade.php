@extends('layouts.app-without-sidebar')

@section('titre', 'Logotype')

@pushonce('styles')
<link rel="stylesheet" href="{{ mix('/css/formulaire.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/documentation.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ mix('/css/entite/modifier_couleur.css') }}" type="text/css" >
@endpushonce

@section('content')



<style id="style_clair"></style>
<style id="style_sombre"></style>

<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Modifier la couleur</h1>

		<div class="section-content">
			@if(Session::has('success'))
				<p class="explication">La couleur été modifiée !</p>
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
						<p class="titre">* Couleur principale sur thème clair :</p>
						<input type="color" name="couleur_claire" class="input" required id="couleur_claire"value="{{old('couleur_claire') ?? $entite->couleur_claire ?? ''}}">
					</label>
	
					<label class="input_groupe">
						<p class="titre">* Couleur principale sur thème sombre :</p>
						<input type="color" name="couleur_sombre" class="input" required id="couleur_sombre" value="{{old('couleur_sombre') ?? $entite->couleur_sombre ?? ''}}">
					</label>
	
					{{-- <details style="margin-top:2em;">
						<summary>Afficher les tests de couleurs.</summary>
						<p>La couleur de la police sera déterminée automatiquement entre le blanc et le noir en fonction du meilleur contraste.</p>
						<h1>CECI EST TEST</h1>
						<a class="documentation_liste" href="#" style="margin-bottom:2em;">
							<div>
								<span class="icon-security" title="documentation privée"></span>
								<span class="titre">C'est juste un élément de test</span>
								<p class="contenu_md"># Comment se déroule le test ? ## changer la couleur. Pour changer la couleur, il suffit de cliquer sur le champ prévu à cet effet.</p>
								<div class="categories" raw="reseau test tech">
										<span>#reseau</span>
										<span>#test</span>
										<span>#tech</span>
								</div>
							</div>
						</a>
						<div class="bouton primaire" style="float:right;">COUCOU</div>
						<div class="bouton secondaire" style="float:right;margin-right:1em;">Coucou ?</div>
					</details> --}}
				</div>
					
				<span>* les champs marqués d'une astérisque sont obligatoires</span>
				<button type="submit" class="bouton primaire" style="float:right;"><span>{{$creation==1 ? "SUIVANT" : "MODIFIER"}}</span></button>
			</form>
		</div>
	</section>
</main>

@endsection
