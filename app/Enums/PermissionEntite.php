<?php

namespace App\Enums;

enum PermissionEntite:int
{
    case ROOT_ENTITE = 0;
    case POST_MANAGE = 1;
    case EVENT_MANAGE = 2;
    case ROLE_MANAGE = 3;
    case MEMBER_VOTE_MANAGE = 4;
    case NETWORK_MANAGE = 5;
    case GROUP_MANAGE = 6;
    case ACCES_ALL_PHOTOS = 7;
    case FILE_MANAGE = 8;
    case PHOTO_MANAGE = 9;
    case SHOP_MANAGE = 10;
    case PAYMENT_MANAGE = 11;
    case FORM_MANAGE = 12;
    case INVENTORY_MANAGE = 13;
    case ACCOUNTING_MANAGE = 14;
    case TOURNAMENT_MANAGE = 15;
    case DM_MANAGE = 16;
    case ACCESS_MANAGE = 17;
    case ENTITY_MANAGE = 18;
}
