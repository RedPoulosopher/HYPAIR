<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>HypAIR - @yield('titre')</title>
		
		@include('pwa.meta')

		@vite(['resources/css/default.scss',
			'resources/css/importants/layout-without-sidebar.scss',
			'resources/css/components/select-popup.scss',
			'resources/css/components/pwa-popup.scss'])
			
		@stack('styles')
	</head>
	
	<style>
		#wrapper {
			padding-left:inherit;
			padding-top: 30px 
		}
	</style>

	<body class="dark-theme">
		@stack('start-scripts')
		@include('layouts.theme')
		
		<div id="wrapper">
			@yield('content')
			<footer>
				<a href="/a-propos">Fait avec amour par l'AIR - Tous droits réservés</a>
			</footer>
		</div>

		<script src="https://kit.fontawesome.com/1087e6f14a.js" crossorigin="anonymous"></script>
		@stack('end-scripts')
	</body>
</html>
