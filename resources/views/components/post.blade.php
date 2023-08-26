{{-- COMPONENT des évènements de la page d'accueil --}}

@php
    use App\Http\Controllers\PostController;
@endphp

<article class="post card" post_id="{{ $post->id }}" entite_uid="{{ $post->entite->uid }}">

    <div class="header" style="{{ count($post->tags) > 0 ? '' : 'grid-template-rows: 1fr; row-gap: 0;' }}">

        <a href="{{ $post->entite->lien_relatif() }}" class="thumbnail">
            <img src="{{ $post->entite->logo_url('petit') }}" alt="Logo {{ $post->entite->nom }}">
        </a>
        <div class="details">
            <a href="/{{ $post->entite->uid }}/entite/post/{{ $post->id }}">
                <h2>{{ $post->titre }}</h2>
            </a>
            <p>Posté par {{ $post->entite->nom }}<span class="separator">•</span>Il y a
                {{ PostController::date_apparition_to_duration($post->date_apparition) }}</p>
            @if ($post->confidentiel != 0)
                <p id="confidentiel" title="Ce post n'est visible que pour votre campus. Ne pas partager"
                    class="tooltip"><i class="fa-solid fa-lock" id="confidentiel-icon"></i>Ce post est confidentiel</p>
            @endif
        </div>

        <div class="tags">
            @foreach ($post->tags as $tag)
                <div class="tag" style="background-color: {{ $tag->couleur }};">{{ $tag->name }}</div>
            @endforeach
        </div>

        <div class="arrow-display">
            {{-- Flèche rouge pour dérouler la description --}}
            <svg class="arrow" post_id="{{ $post->id }}" width="42" height="24" viewBox="0 0 42 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21L39 3" stroke="#CC3345" stroke-width="6" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

    </div>

    <div class="description" id="description-{{ $post->id }}">
        <div class="img-container">
            @foreach ($post->bannieres as $banniere)
                <img src="{{ Storage::url($banniere->path) }} " alt="bannière">
            @endforeach
        </div>
        {{-- CAROUSEL --}}
        {{-- @if (count($post->bannieres) > 0)
            <div class="slideshow-container">
                @for ($i = 0; $i < count($post->bannieres); $i++)
                    <div id="slider_{{ $post->id }}" class="mySlides fade">
                        <div class="numbertext">{{ $i + 1 }} / {{ count($post->bannieres) }}</div>
                        <img src={{ Storage::url($post->bannieres[$i]->path) }} style="width:100%">
                    </div>
                @endfor

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        @endif --}}

        {{-- DESCRIPTION --}}
        {!! Str::markdown(strip_tags($post->description ?? '')) !!}
    </div>

</article>


@pushonce('end-scripts')
    <script>
        // Ce script commande l'affichage des descriptions des posts
        postId = {{ $post->id }};
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
                    description.style.maxHeight = null;
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
