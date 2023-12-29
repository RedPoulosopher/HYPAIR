<a 
    class="reseau-social {{ $reseau->type_de_lien() == 'COPY' ? 'copy' : '' }}"
    {{ ($reseau->type_de_lien() == 'tel:' ? '' : 'target=_blank') }}
    href="{{ ($reseau->type_de_lien() == 'COPY' ? '' : $reseau->type_de_lien())  .  $reseau->lien }}"
    style="background-color: {{ $reseau->liste->couleur }}; background: linear-gradient(to right, {{ $reseau->liste->couleur }}); color:{{ $reseau->liste->couleur_police }};"
>
    <img src="{{ mix('/images/logo_reseaux/' . strtolower($reseau->liste->nom) . '.svg') }}">
    <p style="color: {{$reseau->liste->couleur_police}}"> {{ $reseau->liste->nom }}</p>       
</a>

@pushonce('end-scripts')
    <script defer>
        var el_reseaux_sociaux = document.querySelectorAll('.reseau-social.copy');
        
        for(let i = 0; i < el_reseaux_sociaux.length; i++){
            el_reseaux_sociaux[i].addEventListener('click', (event)=>{
                //Si le réseau n'est pas un lien ni un numéro de tel, on le copie dans le presse-papiers
                event.preventDefault()
                event.stopPropagation()
                copierDansPressePapier(event.target.href)
            })
        }



        function copierDansPressePapier(textToCopy) {
            navigator.permissions.query({
                name: "clipboard-write"
            }).then((result) => {
                if (result.state === "granted" || result.state === "prompt") {
                    navigator.clipboard.writeText(textToCopy);
                    alert("Réseau social copié dans le presse-papier")
                }
            });
        }
    </script>
@endpushonce