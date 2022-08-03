@extends('layouts.app')

@section('titre', 'Evènement')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<div id="wrapper">
    <div id="contenu" class="petit">
        <h1>- Créer un nouvel évènement -</h1>
        @if(Session::has('success'))
        <p class="explication">Bienvenue ! Ici vous pourrez créer un évènement.</p>
        @endif
        <form method="POST">
            @csrf
            @if ($errors->any())
            <div class="erreurs">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">* Titre :</p>
                    <input type="text" name="titre" class="input" id="titre_doc" required value="{{old('titre') ?? $evenement->titre ?? ''}}"/>
                </label>
            </div>

            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">* Description de l'évènement :</p>
                    <textarea name="description" pattern=".{30,250}" required title="Au moins 30 caractères dans la description, et au plus 250" rows="5">{{old('description') ?? $evenement->description ?? ''}}</textarea>
                </label>


            </div>

            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">* Début de l'évènement :</p>
                    <input type="datetime-local" name="temps_debut" class="input" required value="{{old('temps_debut') ?? $evenement->fin_mise_en_avant ?? '' }}" min="01-01-2000" max="12-31-2099"/>
                </label>


                <label class="input_groupe">
                    <p class="titre">* Fin de l'évènement :</p>
                    <input type="datetime-local" name="temps_fin" class="input" required value="{{old('temps_fin') ?? $evenement->fin_mise_en_avant ?? '' }}" min="2000-01-01" max="2100-12-31"/>
                </label>
            </div>


            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">Lieu :</p>
                    <input type="text" name="lieu" class="input" id="lieu_evenement" value="{{old('lieu') ?? $evenement->lieu ?? ''}}"/>
                </label>
            </div>


            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">Nombre maximum de participants :</p>
                    <input type="number" name="max_participation" class="input" id="max_participation_evenement" value="{{old('max_participation') ?? $evenement->max_participation ?? ''}}" min="0" />
                </label>
            </div>


            <div class="groupe ombre_petite">
                <label class="input_groupe">
                    <p class="titre">* Confidentialité :</p>
                    <select name="confidentialite" class="input" spellcheck="false" required select="{{old('confidentialite') ?? $evenement->confidentialite ?? ''}}">
                        <option value="0" selected>Public</option>
                        <option value="1">Membres de l'association</option>
                        <option value="2">Responsables & bureau</option>
                        <option value="3">Bureau</option>
                        <option value="4">Président⸱e⸱s et vice-président⸱e</option>
                    </select>
                </label>

                <label class="input_groupe">
                    <p class="titre">* Pour cotisant :</p>
                    <p class="description">Evènement seulement ouvert aux cotisants ?</p>
                    <select name="pour_cotisant" class="input" spellcheck="false" required select="{{old('pour_cotisant') ?? $evenement->pour_cotisant ?? ''}}">
                        <option value="0" selected>Oui</option>
                        <option value="1">Non</option>
                    </select>
                </label>
            </div>


            <span>* Les champs marqués d'une astérisque sont obligatoires</span>
            <button type="submit" class="bouton primaire ombre_petite" style="float:right;"><span>{{$evenement->id ?? false ? "MODIFIER" : "CRÉER"}}</span></button>
        </form>
    </div>
</div>

@endsection