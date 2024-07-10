@props([
    'size' => 24
])

<div id="loading-icon" style="width:{{$size}}px; height:{{$size}}px; margin: {{$size/3}}px;"></div>

<style>
    #loading-icon{
        display: block;
        border-radius: 100%;
        border: 2px solid var(--couleur_accentuation_air);
        border-left-color: transparent;
        border-bottom-color: transparent;
        animation: rotate 1s linear infinite;
    }

    @keyframes rotate{
        from {
            transform: rotate(0);
        }

        to{
            transform: rotate(360deg);
        }
    }
</style>