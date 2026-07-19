{{-- COMPONENT des évènements de la page d'accueil --}}

@php
    use App\Http\Controllers\PostController;
@endphp

<article class="post card" post_id="{{ $post->uid }}" entite_uid="{{ $post->entite->uid }}">

    <div class="header" style="{{ $post->tags!="" ? '' : 'grid-template-rows: 1fr; row-gap: 0;' }}">
        <a href="{{ $post->entite->lien_relatif() }}" class="thumbnail">
            <img src="{{ $post->entite->getLogo?->url() }}" alt="Logo {{ $post->entite->nom }}">
        </a>
        <div class="details">
            <a href="{{ $post->url() }}">
                <h2>{{ $post->title }}</h2>
            </a>
            <p>Posté par {{ $post->entite->name }}<span class="separator">•</span>
                @foreach ($post->entite_collab as $entite)
                    {{ $entite->name }}
                @endforeach
            </p>
        </div>

        <div class="tags">
            @if ($post->tags!="")
                @foreach (explode(",",$post->tags) as $tag)
                    <div class="tag" style="background-color: #cc3345;">{{ $tag }}</div>
                @endforeach
            @endif
        </div>

        <div class="arrow-display">
            {{-- Flèche rouge pour dérouler la description --}}
            <svg class="arrow" post_id="{{ $post->uid }}" width="42" height="24" viewBox="0 0 42 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21L39 3" stroke="#CC3345" stroke-width="6" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

    </div>

    <div class="description" id="description-{{ $post->uid }}">
        {{-- CAROUSEL --}}
        @isset($post->banner)
            <div class="slideshow-container">
                <img src="{{ $post->banner?->url() }}"/>
            </div>
            <br>
        @endisset

        @if ($post->event)
            <a id="rattachement" href="/{{ $post->entite->uid }}/entite/evenement/{{ $post->event->slug }}"><i
                    class="fa-solid fa-link"></i>Ce post est rattaché à l'évènement "{{ $post->event->title }}"</a>
        @endif
        <div class="line"></div>

        {{-- DESCRIPTION --}}
        {!! Str::markdown(strip_tags($post->content ?? '')) !!}
    </div>

</article>


@pushonce('end-scripts')
    <script>
        // Ce script commande l'affichage des descriptions des posts
        postId = "{{ $post->uid }}";
        // Ajouter un EventListener sur chaque flèche rouge
        arrows = document.getElementsByClassName("arrow")

        // Commander l'affichage des descriptions
        descriptions = document.getElementsByClassName("description")
        for (let i = 0; i < arrows.length; i++) {
            arrows[i].addEventListener("click", (event) => {

                postId = event.currentTarget.getAttribute("post_id")
                descriptionName = "description"

                if (postId) {
                    descriptionName = descriptionName + '-' + postId

                    //Toggle description
                    description = document.getElementById(descriptionName)
                    description.classList.toggle("visible");
                    if (description.style.maxHeight) {
                        description.style.maxHeight = null;
                    } else {
                        description.style.maxHeight = description.scrollHeight +
                            "px"; //On utilise max-height pour animer l'affichage de la description
                    }
                    //Rotation de la flèche
                    event.currentTarget.classList.toggle("visible");
                }

            })
        }


        var mobileResponsive = window.matchMedia('(max-width: 710px)')

        window.addEventListener('resize', function(event) {
            if (mobileResponsive.matches) {
                for (let i = 0; i < descriptions.length; i++) {
                    descriptions[i].style.maxHeight = null;
                    descriptions[i].classList.remove("visible");
                }
                for (let i = 0; i < arrows.length; i++) {
                    arrows[i].classList.remove("visible");
                }
            }
        }, true);


        //Commander l'affichage des détails lorsque l'on clique sur un event
        posts = document.getElementsByClassName("post")
        for (let i = 0; i < arrows.length; i++) {
            posts[i].addEventListener("click", (event) => {

                if (mobileResponsive.matches) {
                    postId = event.currentTarget.getAttribute("post_id")
                    entiteUid = event.currentTarget.getAttribute("entite_uid")

                    window.location.href = "/" + entiteUid + "/entite/post/" + postId;
                }
            })
        }

        // CAROUSEL
        // let slideIndex = 1;
        // showSlides(slideIndex);

        // function plusSlides(n) {
        //     showSlides(slideIndex += n);
        // }

        // function currentSlide(n) {
        //     showSlides(slideIndex = n);
        // }

        // function showSlides(n) {
        //     let i;
        //     let slides = document.getElementById("slider_" + postId);
        //     let dots = document.getElementsByClassName("dot");
        //     if (n > slides.length) {
        //         slideIndex = 1
        //     }
        //     if (n < 1) {
        //         slideIndex = slides.length
        //     }
        //     for (i = 0; i < slides.length; i++) {
        //         slides[i].style.display = "none";
        //     }
        //     for (i = 0; i < dots.length; i++) {
        //         dots[i].className = dots[i].className.replace(" active", "");
        //     }
        //     slides[slideIndex - 1].style.display = "block";
        //     dots[slideIndex - 1].className += " active";
        // }
    </script>
@endpushonce
