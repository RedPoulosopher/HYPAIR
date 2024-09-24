@extends('layouts.app-without-sidebar')

@section('titre', 'Editer le profil')

@pushonce('styles')
	@vite([
		'resources/css/formulaire.scss',
		'resources/css/espace_utilisateur/editer_infos_profil.scss',
	])
@endpushonce

@section('content')

<main id="main-content">
	<section>
		<h1><span class="icon-user-edit"></span> Modification des infos du profil</h1>
		{{-- ancien bouton retour ci-dessous, a enlever lorsde l'ajout des breadcrumbs --}}
		{{-- <a href="/home" class="bouton secondaire">< Retour au profil</a> --}}
		
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
			<div style="display:flex; flex-wrap:wrap; column-gap:10px">
				<label class="input_groupe" style="flex-grow:1;">
							<p class="titre">Nom <span style="color:var(--couleur_accentuation);">*</span></p>
							<input type="text" name="nom" class="input" required maxlength="40" value="{{$user->nom}}"/>
						</label>
				<label class="input_groupe" style="flex-grow:1;">
							<p class="titre">Prenom <span style="color:var(--couleur_accentuation);">*</span></p>
							<input type="text" name="prenom" class="input" required maxlength="40" value="{{$user->prenom}}"/>
						</label>
				<label class="input_groupe">
							<p class="titre">Pronoms</p>
							<input type="text" name="pronoms" class="input" style="max-width:20ch;" maxlength="20" value="{{$user->pronom}}"/>
						</label>
			</div>
			<label class="input_groupe">
						<p class="titre">Identifiant</p>
						<p class="description">Uniquement à titre informatif, celui-ci ne peut être changé</p>
						<input type="text" name="uid" class="input" style="opacity:0.5; max-width:30ch;" disabled value="{{$user->uid}}"/>
					</label>
					<label class="input_groupe">
						<p class="titre">Biographie</p>
				<p class="description">Vous n'avez pas d'idée ? Indiquez par exemple votre promotion, votre classe, vos passions, vos associations....</p>
						<textarea name="bio" class="input" maxlength="400" rows="5">{{$user->bio}}</textarea>
					</label>
				</div>
			<div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:space-between; align-items:flex-start;">
			<span style="flex-grow:1; flex-basis:20ch;"><span style="color:var(--couleur_accentuation);">*</span> Les champs marqués d'une astérisque sont obligatoires</span>
			<button type="submit" class="bouton primaire" style="margin-left:auto;">MODIFIER</button>
			</div>
		</form>
	</section>
</main>

@endsection
