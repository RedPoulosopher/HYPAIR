<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Erreur @yield('code_erreur') - HypAIR</title>
		<link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css" >
	</head>
	
	<style>
		#wrapper {
			padding-left:inherit;
			min-width: 100vw;
			min-height: 100vh;
			box-sizing: border-box;
			padding: 0 5vw;
			
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
	</style>
	
	<body class="dark-theme">
		@include('layouts.theme')
		
		<div id="wrapper">
			<div id="contenu" class="tres_petit">
				@yield('content')
			</div>
		</div>
	</body>
</html>
