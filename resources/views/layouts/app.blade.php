<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('titre', 'Test') - HypAIR</title>
		<link rel="stylesheet" href="/css/app.css" type="text/css" >
	</head>
	
	<body class="dark-theme">
		<style>
			body.light-theme{
				--couleur_accentuation: {{session('entite_couleur_claire')}};
				--couleur_police_accentuation: {{session('entite_couleur_police_accentuation_claire')}};
			}
			body.dark-theme{
				--couleur_accentuation: {{session('entite_couleur_sombre')}};
				--couleur_police_accentuation: {{session('entite_couleur_police_accentuation_sombre')}};
			}
		</style>
		@include('layouts.theme')

		@includeFirst(['menus.' . Request::route('entite_uid'), 'menus.#defaut'])

		@include('fenetre_contextuelle.#defaut')
		
		@yield('content')
	</body>
</html>
