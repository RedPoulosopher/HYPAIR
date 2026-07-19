<?php

namespace App\Enums;

enum PermisionsEntite:int
{
    public const ROOT_ENTITE = 0;
    public const POST_MANAGE = 1;
    public const EVENT_MANAGE = 2;
    public const ROLE_MANAGE = 3;
    public const MEMBER_VOTE_MANAGE = 4;
    public const RESEAU_MANAGE = 5;
    public const GROUP_MANAGE = 6;
    public const ACCES_ALL_PHOTOS = 7;
    public const FILE_MANAGE = 8;
    public const PHOTO_MANAGE = 9;
    public const SHOP_MANAGE = 10;
    public const PAYMENT_MANAGE = 11;
    public const FORM_MANAGE = 12;
    public const INVENTORY_MANAGE = 13;
    public const ACCOUNTING_MANAGE = 14;
    public const TOURNAMENT_MANAGE = 15;
    public const DM_MANAGE = 16;
    public const ACCESS_MANAGE = 17;
    public const ENTITE_MANAGE = 18;
}
