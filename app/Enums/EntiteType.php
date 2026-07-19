<?php

namespace App\Enums;

enum EntiteType: string
{
    case Administration = 'administration';
    case Syndicat = 'syndicat';
    case Association = 'association';
    case Bureau = 'bureau';
    case Comite = 'comité';
    case Club = 'club';
    case Liste = 'liste';
}