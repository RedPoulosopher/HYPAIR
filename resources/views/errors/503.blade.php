@extends('layouts.erreur')

@section('code_erreur', '503')

@section('content')
    <h1 style="font-family: 'GearsOfPeace';font-size:5em">503</h1>

    <h1>Nous travaillons ici ! Tu pourras bientôt revenir</h1>

    <div>
        <style>
            #nuage {
            stroke-dasharray: 2030;
            stroke-dashoffset: 2030;
            animation: dash 5s ease-in-out infinite;
            }
            @keyframes dash {
                50% {
                    stroke-dashoffset: 0;
                }
                100% {
                    stroke-dashoffset: -2030;
                }
            }
            svg {
                max-width:300px;
                margin: 40px 0px;
            }
        </style>

        <svg class="centre-element" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 762.5 459.1" width="600px">
            <g id="logo_plat" data-name="logo plat">
            <path id="nuage" d="M762.3,308.1c-2.3-9.9-4.8-20-8.9-29.2a133.7,133.7,0,0,0-33.8-46.1A141.3,141.3,0,0,0,691,213.4c-11.8-6.2-24.4-9.9-37.4-12.8a6,6,0,0,1-3.5-3.3c-4.6-13.6-9.2-27.1-16.1-39.9s-14.8-26-23.9-37.8c-6.6-8.7-14.7-16.1-22.7-23.6A197.3,197.3,0,0,0,554,70.4c-3.6-2.2-7.1-4.5-10.9-6.4-6-3.1-12-6.4-18.3-8.8-10.9-4.2-21.9-8.8-33.2-11.6s-24.8-4.4-37.3-6.1c-15.6-2-31.1-.8-46.5,1-17.3,2-34,6.9-50.3,12.6-6.2,2.2-11.8,5.5-17.8,8.1-12.2,5.1-23,12.7-33.9,20.1a142.6,142.6,0,0,0-12.2,9.9c-3.5,3-6.8,6-10.1,9.1a82.8,82.8,0,0,0-6.4,6.8c-4.9,5.7-10.4,11-14.8,17.1-6.7,9.3-14.3,18.1-18.9,28.9-2.8,6.7-6.8,13-9.9,19.5-1,2.2-2.2,3.4-4.5,3.8l-9.4,2.2A162.6,162.6,0,0,0,178.7,194c-7.5,4.3-14.3,10-20.7,15.8a216.4,216.4,0,0,0-18.9,19.4c-7.3,8.4-12.5,18.2-17.5,28a8.7,8.7,0,0,1-6,4.7,103.6,103.6,0,0,0-13.4,4.1c-15.7,6.7-29.5,16.1-40.8,29.1a99.4,99.4,0,0,0-16.7,25.5,107.7,107.7,0,0,0-9.9,48.5A103.2,103.2,0,0,0,45.7,414a62.4,62.4,0,0,0,7.4,11c19.1,23.8,48.3,37.3,78.8,37.4l533.9,1.2s17.6-5.8,25.7-9.9a133.6,133.6,0,0,0,46.3-38.9A130.8,130.8,0,0,0,761,366.2C765.8,347.1,766.9,327.5,762.3,308.1Z" transform="translate(-18.8 -20.4)" style="fill: none;stroke: #a90000;stroke-linecap: round;stroke-miterlimit: 10;stroke-width: 25px"/>
            </g>
        </svg>
    </div>
    <p>Nos meilleurs ingénieurs travaillent sur une amélioration du site. Si tu veux vraiment nous parler, tu peux toujours nous contacter !</p>
@endsection
