<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('titre') - AIR</title>
		<link rel="stylesheet" href="/css/general.css" type="text/css" >
	</head>
	
	<body class="dark-theme">
		@include('layouts.theme')
		
		<div id="wrapper">
			@yield('content')
		</div>
	</body>
</html>