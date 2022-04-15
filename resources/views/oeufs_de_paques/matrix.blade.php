@extends('layouts.vide')

@section('titre','matrix')

@section('content')
<canvas width="500" height="200" id="canv"></canvas>
<a href="accueil"><div class="bouton primaire icon-after-maison" style="position: absolute;bottom: 30px ;left:50%;transform:translateX(-50%);"><span>Accueil</span></div></a>
<script>
const canvas = document.getElementById('canv');
const ctx = canvas.getContext('2d');

// set the width and height of the canvas
const w = canvas.width = document.body.offsetWidth;
const h = canvas.height = document.body.offsetHeight;

// draw a black rectangle of width and height same as that of the canvas
ctx.fillStyle = '#000';
ctx.fillRect(0, 0, w, h);

const cols = Math.floor(w / 20) + 1;
const ypos = Array(cols).fill(0);
ypos.forEach((y, ind) => {ypos[ind]=-Math.random()*300})

function matrix () {
	ctx.fillStyle = '#0001';
	ctx.fillRect(0, 0, w, h);

	ctx.fillStyle = '#a90000';
	ctx.font = '15pt monospace';

	ypos.forEach((y, ind) => {
		const text = String.fromCharCode(Math.random() * 128);
		const x = ind * 20;
		ctx.fillText(text, x, y);

		if (y > 100 + Math.random() * 10000) ypos[ind] = 0;
		else ypos[ind] = y + 20;
	});
}

// render the animation at X FPS.
setInterval(matrix, 80);

</script>
	
@endsection