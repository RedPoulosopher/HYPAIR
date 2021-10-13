<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Erreur @yield('code_erreur') - AIR</title>
		<link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css" >
	</head>

	<script src="/js/jquery-3.3.1.slim.min.js"></script>
	
	<body class="light-theme">
		@include('partials.menu')

		<style>
			@media (max-width: 1099.98px) {
				#contenu{
					width:100%;
				}
			}
		
			@media (min-width: 1100px) {
				#contenu{
					width:800px;
				}
			}
		</style>
		<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
			<div id="contenu">
				@yield('content')
			</div>
		</div>
	</body>
</html>