<a 
    class="reseau-social {{ $reseau->type_de_lien() == 'COPY' ? 'copy' : '' }}"
    {{ ($reseau->type_de_lien() == 'tel:' ? '' : 'target=_blank') }}
    href="{{ ($reseau->type_de_lien() == 'COPY' ? '' : $reseau->type_de_lien())  .  $reseau->pivot->url }}"
    lien="{{ $reseau->pivot->url }}"
    style="background-color: {{ $reseau->color }}; background: linear-gradient(to right, {{ $reseau->color }}); color:{{ $reseau->font_color }};"
>
    <img src="{{ Vite::Image('logo_reseaux/' . strtolower($reseau->nom) . '.svg') }}">
    <p style="color: {{$reseau->font_color}}"> {{ $reseau->nom }}</p>       
</a>

@pushonce('end-scripts')
    <script defer>
        var el_reseaux_sociaux = document.querySelectorAll('.reseau-social.copy');
        
        for(let i = 0; i < el_reseaux_sociaux.length; i++){
            el_reseaux_sociaux[i].addEventListener('click', (event)=>{
                //Si le réseau n'est pas un lien ni un numéro de tel, on le copie dans le presse-papiers
                event.preventDefault()
                event.stopPropagation()
                
                copierDansPressePapier(event.currentTarget.getAttribute('lien'))
            })
        }



        function copierDansPressePapier(textToCopy) {
            navigator.clipboard.writeText(textToCopy);
            alert("Réseau social copié dans le presse-papier")
        }
    </script>
@endpushonce