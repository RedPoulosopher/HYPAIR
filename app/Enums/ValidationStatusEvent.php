<?php

namespace App\Enums;

enum ValidationStatusEvent
{
    public const PROPOSITION = "Proposition";
    public const DEMANDE = "Déclaration déposée";
    public const VALIDE = "Déclaration validée";
    public const ORGANISE = "Soirée organisée";
    public const ANNULE = "Annulé";
}
