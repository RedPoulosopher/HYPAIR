<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title', 'Test') - AIR</title>
		<link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css" >
	</head>

	<script src="/js/jquery-3.3.1.slim.min.js"></script>
	
	<body class="light-theme">
		@include('partials.theme')

		@include((null !== request()->get('association_slug')) ? 'menus_asso.' . request()->get('association_slug') : 'partials.menu')
		
		@yield('content')
	</body>
</html>