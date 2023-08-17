<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Offline - HypAIR</title>
		
		@include('pwa.meta')

		<link rel="stylesheet" href="/css/default.css" type="text/css" >
		<link rel="stylesheet" href="/css/offline.css" type="text/css" >
	</head>

    <body>
        {{-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" fill="#fff"><path d="M24 .01c0-.01 0-.01 0 0L0 0v24h24V.01zM0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M22.99 9C19.15 5.16 13.8 3.76 8.84 4.78l2.52 2.52c3.47-.17 6.99 1.05 9.63 3.7l2-2zm-4 4c-1.29-1.29-2.84-2.13-4.49-2.56l3.53 3.53.96-.97zM2 3.05L5.07 6.1C3.6 6.82 2.22 7.78 1 9l1.99 2c1.24-1.24 2.67-2.16 4.2-2.77l2.24 2.24C7.81 10.89 6.27 11.73 5 13v.01L6.99 15c1.36-1.36 3.14-2.04 4.92-2.06L18.98 20l1.27-1.26L3.29 1.79 2 3.05zM9 17l3 3 3-3c-1.65-1.66-4.34-1.66-6 0z"/></svg> --}}
        <img src="/images/offline.svg" alt=""/>
		
		<h1>Offline</h1>
        <p>Il semblerait que vous n'ayez pas de connection internet pour le moment. Réessayez plus tard.</p>
        
        <div class="centre-element bouton primaire" onclick="location.reload()" style="background-color:var(--couleur_accentuation_air); cursor:pointer;"><span>Réessayer</span></div>

    </body>

</html>
