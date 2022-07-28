<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Projet;
use \App\Models\Avancee;
use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AvanceeController extends Controller
{
    public function create(){ //réservé à l'AIR

		$projet = Projet::existe_slug(Route::get('/projet/{slug}/avancee/nouvelle',function ($slug){
			return $slug;
		}), session('entite_id'));

		if(!$projet){abort(404);}
		$niveau_administation = AutorisationGestion::protectionPage("gerer_projet");
		$confidentialites = config('roles');
		//$membre = Auth::user()->membres()->where("id", session(["entite_id"]));

		return view('avancee.creation', [
			'projet' => $projet
			])->with('titre','Nouvelle avancee')->with('confidentialites',$confidentialites);
	}

	public function store(Request $request)
	{
		$avancee= $this->formulaire_avancee($request);

		$existe = Avancee::existe_slug($avancee->slug,$avancee->entite_id, $avancee->projet_id)->first();
		if($existe){ return back()->withErrors(["Cet avancee existe déjà pour votre entité."]); }
		$chemin_image="image/imageTest/";
		$chemin_file="file/";
		$nom_image =strval($request->image);
		$nom_file="";
		Storage::put($chemin_image.$nom_image,$avancee->image);
		Storage::put($chemin_file.$nom_file,$avancee->pdf);
		$avancee->save();

		return redirect()->route('avancee_afficher',['entite_uid' =>$request->route('entite_uid'),'slug'=>$request->route('slug'),'slug_avancee'=>$avancee->slug]);
	}

	public function formulaire_avancee(Request $request,$update=false){
		$validation = [
			'titre' => ['filled','max:120'],
			'description_md'=>['filled','max:3000'],

		];

		$this->validate($request, $validation);
		
		if($update){
			$avancee = Avancee::existe($request->route('avancee_id'));
		} else{
			$avancee = new Avancee;
		}
		$projet = Projet::existe_slug($request->route('slug'), session('entite_id'));
		if(!$projet){
			abort(404);
		}
		$projet = $projet->first();

		$avancee->titre = $request->titre;
		$avancee->slug = Str::slug($request->titre, '-');
		$avancee->projet_id =$projet->id;
		$avancee->entite_id=session('entite_id');
		$avancee->description_md = $request->description_md;
		$avancee->image = $request->image;
		$avancee->pdf = $request->file;

		return $avancee;
	}

	public function show(Request $request){
		$niveau_administration = AutorisationGestion::protectionPage("gerer_projet");
		$avancee = Avancee::index($niveau_administration)->get();
		$projet = Projet::existe_slug($request->route('slug'), session('entite_id'));
		if(!$projet){
			abort(404);
		}
		$projet = $projet->first();

		$avancee = Avancee::existe_slug($request->route('slug_avancee'),session('entite_id'),$projet->id);
		if(!$avancee){
			abort(404);
		}
		$avancee = $avancee->first();
		$modification_date = $avancee->updated_at->setTimezone(new DateTimeZone("EUROPE/PARIS"))->diffForHumans();
		$image = Storage::get('/storage\app\public\image\imageTest\test.png');

		return view('avancee.show',[
			'avancee' => $avancee,
			'slug'=> $request->route('slug'),
			'image'=>$image,	
			'modification_date'=> $modification_date,
			'gerer_projet' => AutorisationGestion::gestion("gerer_projet")
		]);
	}

	
	public function index(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();
		$projet = Projet::existe_slug($request->route('slug'), session('entite_id'));
		if(!$projet){
			abort(404);
		}
		Carbon::setLocale('fr');
		$projet = $projet->first();
		$now=Carbon::now()->format('Y-m-d');
		$avancee = Avancee::index($projet->id)->get();
		$creation_date= $projet->created_at->setTimezone(new DateTimeZone("EUROPE/PARIS"))->format('Y-m-d');
		if(Carbon::createFromFormat('Y-m-d', $projet->date_fin)->gt($now)){
			$temps_restant= Carbon::createFromFormat('Y-m-d', $projet->date_fin)-> diffInDays();
		}
		else{
		   $temps_restant = 0;
		}
		$modification_date = $projet->updated_at->setTimezone(new DateTimeZone("EUROPE/PARIS"))->diffForHumans();
		return view('avancee.index', [
			'projet' => $projet,
			'creation_date'=>$creation_date,
			'avancees' => $avancee,
			'temps_restant'=>$temps_restant,
			'modification_date'=>$modification_date,
			'gerer_projet' => AutorisationGestion::gestion("gerer_projet")
		]);
	}
	

	public function update(Request $request)
	{
		$avancee = $this->formulaire_avancee($request,true);
		$avancee->save();

		return redirect()->route('avancee_afficher',['entite_uid' => $request->route('entite_uid'),'slug'=>$request->route('slug'),'slug_avancee'=>$avancee->slug]);
	
	}
	/*public function update(Resquet $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();
	}*/


	public function edit(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$avancee = Avancee::existe($request->route('avancee_id'));
		if(!$avancee){abort(404);}
		
		return view('avancee.creation')
				->with('avancee', $avancee)
				->with('titre','Modifier l\'avancee');
	}

}