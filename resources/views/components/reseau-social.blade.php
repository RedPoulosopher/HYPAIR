<a target="_blank" class="reseau-social ombre_petite" tabindex="3" href="{{ $reseau->liste->pre_url . $reseau->cle }}" style="background-color: {{ $reseau->liste->couleur }}; background: linear-gradient(to right, {{ $reseau->liste->couleur }}); color:{{ $reseau->liste->couleur_police }};">
    <img src="/images/logo_reseaux/{{ strtolower($reseau->liste->nom)}}.svg">
    <p style="color: {{$reseau->liste->couleur_police}}"> {{ $reseau->liste->nom }}</p>       
</a>