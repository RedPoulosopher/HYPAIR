<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Passation
    |--------------------------------------------------------------------------
    |
    | En deça de ce mois, toutes les passations sont faites pour l'année en cours.
    | Au delà de ce mois, les passations sont faites pour l'année d'après
    |
    | e.g : Le président du caméléon peut organiser lui même la passation de son comité
    | entre `debut_passation` et `fin_passation_pour_entite`.
    |
    */

    'mois_debut_passation' => 2, //1er fevrier
    'mois_fin_passation' => 12, //1er décembre

    // Les listes peuvent ajouter des membres pour le "mandat" actuel même après le 1er févrirer
    'mois_debut_passation_liste' => 4, //1er avril


    /*
    |--------------------------------------------------------------------------
    | Mandat
    |--------------------------------------------------------------------------
    |
    | Toutes les fiches membres sont désactivées après cette date. Cela veut dire que
    | chaque entité n'est plus suivie par personne, et que tous les rôles avec des
    | responsabilités ne sont plus.
    |
    */

    'date_fin_mandat' => '05-01', //1er mai
    
    /*
    |--------------------------------------------------------------------------
    | Mandat
    |--------------------------------------------------------------------------
    |
    | Au delà de ce mois, le mandat qui sera affiché sera le nouveau.
    |
    */

    'mois_affichage_nouveau_mandat' => 4, //1er avril
    
    /*
    |--------------------------------------------------------------------------
    | Mandat
    |--------------------------------------------------------------------------
    |
    | Quand on créer un membre pour les archives, date à laquelle on considère
    | que le membre à été créé
    |
    */

    'date_defaut_creation' => '09-01', //1er septembre

];
