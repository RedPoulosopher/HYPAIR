@extends('layouts.app')

@section('titre', 'Evènement')

@section('content')

<link rel="stylesheet" href="/css/formulaire.css" type="text/css" >

<div id="wrapper">
    <div id="contenu" class="petit">
        <h1>- Evènements -</h1>
        @if(Session::has('success'))
        <p class="explication">Bienvenue sur la page concernant les évènements !</p>
        @endif
        <div>
            @csrf
            @if ($errors->any())
            <div class="erreurs">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            

            @if($gerer_evenement)
		    <div style="margin:70px 0px;" class="centre-element">            		
			    <a href="evenement/formulaire" class="bouton tertiaire ombre_petite administrateur">
                    <span>Créer un évènement</span>
                </a>
            </div>
            @endif
		

            <div class="groupe ombre_petite">
                <h2>Liste des évènements créés</h2>
                <table class="groupe" style="text-align: center;">
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Lieu</th>
                        <th>Nombre de participants max</th>
                        <th>Pour cotisants ?</th>
                        <th>Statut</th>
                    </tr> 
                                     
                    @foreach ($tables as $table)
                    <tr>
                        <td><?= $table['titre'] ?></td>
                        <td><?= $table['description'] ?></td>
                        <td><?= $table['temps_debut'] ?></td>
                        <td><?= $table['temps_fin'] ?></td>
                        <td><?= $table['lieu'] ?></td>
                        <td><?= $table['max_participation'] ?></td>
                        
                        @if ($table['pour_cotisant'] == 0)                          
                        <td>Oui</td>                        
                        @else if ($table['pour_cotisant'] == 1)
                        <td>Non</td>
                        @endif

                        @if ($table['validation'] == 1)                          
                        <td>Validé</td>
                        @else if ($table['validation'] == 0)
                        <td>En attente de validation</td>
                        @endif

                    </tr>
                    @endforeach
            </table>
        </div>
      
    </div>
</div>

@endsection