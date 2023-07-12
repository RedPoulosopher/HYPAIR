@extends('layouts.app')

@section('titre', 'Associations')

@section('content')

<style>
	.conteneur_boutons {
		margin-top:40px;
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		gap:20px;
	}
	.gros_bouton {
		width:200px;
		height:200px;
		border: 1px solid var(--gris_1);
		border-radius: 15px;
		display: flex;
		justify-content: center;
		align-items: center;
		box-sizing: border-box;
		padding: 10px;
		text-align: center;
		background: var(--gris_3);
		transition: background 0.15s ease-in-out;
	}
	.gros_bouton:hover {
		background: var(--gris_2);
	}
</style>

<div id="wrapper">
	<!-- Choix du site -->
	<div id="contenu" class="petit">
		<h1>Associations</h1>

		<div class="conteneur_boutons">
			<a class="gros_bouton" href="entites/douai">Douai</a>
			<a class="gros_bouton" href="entites/lille">Lille</a>
		</div>
	</div>

	<!-- Carousel des logos -->

	{{-- Carrousel généré dynamiquement en prenant des logos depuis la bdd --}}
	{{--
	<div class="carrousel">
		@for($i = 0; $i < 16; $i++)
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
	if(window.location.search[0] == "?"){
		tmp = localStorage.getItem('defaut_entites_index_site')
		if(tmp !== undefined){
			window.location.replace('/entites/' + tmp)
		}
	}
</script>

@endsection
