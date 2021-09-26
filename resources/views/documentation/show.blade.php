@extends('layouts.app')

@section('title','Doc - '.$documentation->titre)

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
	.documentation .contenu_doc a {
		text-decoration: underline;
		position: relative;
		padding: 1px 5px;
		margin-right:1.6em;
	}
	.documentation .contenu_doc a::after {
		font-family: 'icomoon' !important;
		content: "\e91c";
		position:absolute;
		margin-top: 0.25em;
		margin-left:0.5em;
	}
}
</style>

<div id="wrapper" style="display:flex;align-items:center;justify-content:center;">
	<div id="contenu">

		<a href="/documentations"><div class="bouton secondaire ombre_petite">< retour aux documentations</div></a>

		<div class="documentation ombre_inset fond">
			<div class="contenu_doc">
				<h1>{{$documentation->titre}}</h1>
				{!! \Illuminate\Support\Str::markdown($documentation->contenu); !!}
			</div>
		</div>

	</div>
</div>
	
@endsection