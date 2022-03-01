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
        return $this->belongsTo(Association::class||user::class);
}
    public function Avancee(){
        return $this->hasMany(Avancee::class);
    }
}
Route::get('/',function(){
    return view('Projet',[
        'Projet' -> Post::all()
    ]);  
});

Route::get('Projet/{Projet}', function ($id){
    return view('projet',[
        'projet'-> Post::findOrFaill($id)
    ]);
});