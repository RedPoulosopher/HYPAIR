@extends('layouts.app')

@section('titre', 'Nous contacter')

@pushonce('styles')
    <link rel="stylesheet" href="{{ mix('css/contact.css') }}" type="text/css" />
@endpushonce

@section('content')

    <main id="main-content" class="moyen">
        <section>

            <h1>Nous contacter</h1>

            <div class="section-content">
                @if (Session::has('success'))
                    <p class="explication">Votre problème va être résolu ! A bientôt.</p>
                @else
                    <p class="explication">Un problème ? Une question ? L'AIR peut sûrement vous aider !</p>
                @endif

                {{-- {!! Form::open() !!}
				<div class="champs_conteneur" for="courriel">
					<label class="champs flex border">
						<p class="titre">Adresse mail :</p>
						<input id="courriel" name="email" class="input affichage_empty" spellcheck="false" required placeholder="ex : air@imt-nord-europe.fr" value="{{Auth::check() && Auth::user()->email ? Auth::user()->email : (Auth::check() ?  Auth::user()->uid . '@' : '')}}"/>
					</label>
				</div>
				<div class="champs_conteneur" for="objet">
					<label class="champs flex border">
						<p class="titre">Objet :</p>
						<input id="objet" name="objet" class="input affichage_empty" required placeholder="Entrez l’objet ici"/>
					</label>
				</div>
				<div class="champs_conteneur" for="requete">
					<label class="champs">
						<p class="titre">Contenu du message : </p>
						<textarea id="requete" name="message" class="affichage_empty" pattern=".{60,}" required title="au moins 60 caractères dans la réponse" rows="13" placeholder="Entrez le texte ici..."></textarea>
					</label>
				</div>
				<p id="mail">N’hésitez pas également à nous contacter sur notre adresse mail : <a href="mailto:air@imt-nord-europe.fr"><em>air@imt-nord-europe.fr</em></a></p>
				<button type="submit" class="bouton primaire icon-after-mail ombre_petite" style="float:right;"><span>ENVOYER</span></button>
			{!! Form::close() !!} --}}
                @if (Auth::check())
                    <p id="mail">N’hésitez pas à nous contacter sur notre adresse mail pour toute demande : <a
                            href="mailto:air@etu.imt-nord-europe.fr"><em>air@etu.imt-nord-europe.fr</em></a></p>
                @else
                    <p class="should-be-connected no-content">Vous devez être connecté pour pouvoir consulter notre adresse
                        mail.
                    </p>
                @endif
            </div>
        </section>
    </main>


@endsection
