<?php
namespace App\Enums;

enum AssoTypeEnum:string
{
    case Comite = 'comité';
    case Bureau = 'bureau';
    case Liste = 'liste';
    case Fakeliste = 'fakeliste';
}