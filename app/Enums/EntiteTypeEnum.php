<?php
namespace App\Enums;

enum EntiteTypeEnum:string
{
    case Association = 'association';
    case Bureau = 'bureau';
    case Club = 'club';
    case Comite = 'comité';
    case Liste = 'liste';
    case Fakeliste = 'fakeliste';
}
