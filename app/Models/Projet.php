<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = [
        'association_id',
        'confidentialite',
        'titre',
        'projet_id',
        'description_courte',
        'chef_projet'
    ];
    public function Projet(){
        return $this->belongsTo(Association::class||User::class);
    }
    public function Avancee(){
        return $this->hasMany(Avancee::class);
    }
}
//test
Route::get('/',function(){
    return view('Projet',[
        'Projet' -> Post::with('association')->get()
    ]);  
});

Route::get('Projet/{Projet:projet_id}', function (Projet $Projet ){
    return view('projet',[
        'projet'-> Post::findOrFaill($Projet)
    ]);
});
Route::get('associations/{association:association_id}',function (Association $association){
    return view('projets',[
        'projets'->$association->projets
    ]);
});