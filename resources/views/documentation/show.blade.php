@extends('layouts.app')

@section('title','Doc - '.$documentation->titre)

@section('content')
<script>
window.MathJax = {
  loader: {
    load: ['input/asciimath', "output/svg"]
  },
  asciimath: {
    delimiters: [['$','$'], ['`','`']]
  }
};
</script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-svg.js"></script>
<script src="ASCIIMathML.js"></script>


<style>
a[href^="mailto:"]:not(.no-icon), a[href^="http"]:not(.no-icon){
	text-decoration: underline;
	position: relative;
	padding: 1px 5px;
	margin-right:1.6em;
}
a[href^="mailto:"]:not(.no-icon):after, a[href^="http"]:not(.no-icon):after{
	font-family: 'icomoon' !important;
	font-style: normal;
	position:absolute;
	margin-top: 0.25em;
	margin-left:0.5em;
}
a[href^="mailto:"]:not(.no-icon):after{
	content: "\e91f" !important;
}
a[href^="http"]:not(.no-icon):after{
	content: "\e91c" !important;
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
	<div id="contenu" class="grand">

		<a href="/documentations"><div class="bouton secondaire ombre_petite">< retour aux documentations</div></a>

		<div class="documentation ombre_inset fond">
			<div class="contenu_doc" id="contenu_doc">
				<h1>{{$documentation->titre}}</h1>
				{{ $documentation->contenu }}
			</div>
		</div>
		<script src="{{asset('js/asciidoctor.js')}}"></script>
		<script>
			var asciidoctor = Asciidoctor()
			document.getElementById("contenu_doc").innerHTML(asciidoctor.convert(document.getElementById("contenu_doc").innerText))
		</script>
	</div>
</div>
	
@endsection