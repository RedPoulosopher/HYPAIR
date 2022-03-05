<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Erreur @yield('code_erreur') - AIR</title>
		<link rel="stylesheet" href="/css/app.css" type="text/css" >
	</head>
	
	<style>
		#wrapper {padding-left:inherit;}
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