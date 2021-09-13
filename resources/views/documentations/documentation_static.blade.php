@extends('layouts.app')

@section('title','documentation - AIR')

@section('content')

<style>
	@media (max-width: 1099.98px) {
		#contenu{
			width:100%;
		}
	}

	@media (min-width: 1100px) {
		#contenu{
			width:1000px;
		}
	}

	.documentation {
		display: flex;
		flex-wrap: nowrap;
		width:100%;
		border-radius: 25px;
		padding: 20px;
		margin-top:15px;
		box-sizing: border-box;
	}
</style>

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
	<div id="contenu">

		<a href="documentations"><div class="bouton secondaire ombre_petite">< retour aux documentations</div></a>

		<div class="documentation ombre_inset fond">
			<div class="contenu_doc">

				@include('markdown')

			</div>
		</div>

	</div>
</div>
	
@endsection