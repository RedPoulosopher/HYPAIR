<?php

namespace App\Enums;

enum ValidationStatusEvent:string
{
    case PROPOSITION = "Proposition";
    case DEMANDE = "Déclaration déposée";
    case VALIDE = "Déclaration validée";
    case ORGANISE = "Soirée organisée";
    case ANNULE = "Annulé";
}
