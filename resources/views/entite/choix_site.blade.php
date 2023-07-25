{{-- Plus utilisé -> remplacé par la combo box --}}

@extends('layouts.app')

@section('titre', 'Associations')

@pushonce('styles')
    <link rel="stylesheet" href="css/choix_site.css" type="text/css" />
@endpushonce

@section('content')


    <div id="main-content" class="petit">
        <!-- Choix du site -->
        <section>
            <h1>Associations</h1>

            <div class="conteneur_boutons">
                <a class="gros_bouton" href="entites/douai">Douai</a>
                <a class="gros_bouton" href="entites/lille">Lille</a>
            </div>
        </section>

        <!-- Carousel des logos -->

        {{-- Carrousel généré dynamiquement en prenant des logos depuis la bdd --}}
        {{--
	<div class="carrousel">
		@for ($i = 0; $i < 16; $i++)
		<div @class(['bande' => true, 'shifted' => ($i % 2 == 1 )])>
			<div class="thumbnail-container">
				<img
					src="/storage/images/entites/{{$entites[3*$i]}}/logos/petit"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/storage/images/entites/{{$entites[3*$i + 1]}}/logos/petit"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/storage/images/entites/{{$entites[3*$i + 2]}}/logos/petit"
					alt="entity_thumbnail"
				/>
			</div>
		</div>
		@endfor
	--}}

        {{-- Carrousel généré manuellement, pour tester sans accéder à la bdd --}}
        {{-- ATTENTION : réduire la div qui suit ! --}}

        {{-- 
	<div class="carrousel">
		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/mastodon.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>

		<div class="bande shifted">
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/piwigo.png"
					alt="entity_thumbnail"
				/>
			</div>
			<div class="thumbnail-container">
				<img
					src="/images/logo_services/peertube.png"
					alt="entity_thumbnail"
				/>
			</div>
		</div>
	</div>
	--}}

    </div>

    <script>
        if (window.location.search[0] == "?") {
            tmp = localStorage.getItem('defaut_entites_index_site')
            if (tmp !== undefined) {
                window.location.replace('/entites/' + tmp)
            }
        }
    </script>

@endsection
