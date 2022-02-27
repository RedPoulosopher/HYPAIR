<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projets extends Model
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
    public function projets(){
        return $this->belongsTo(Association::class||user::class);
}
    public function avancees_projets(){
        return $this->hasMany(avancees_projets::class);
    }
}
Route::get('/',function(){
    return view('projets',[
        'projets' -> Post::all()
    ]);  
});

Route::get('projets/{projets}', function ($id){
    return view('projet',[
        'projet'-> Post::findOrFaill($id)
    ]);
});