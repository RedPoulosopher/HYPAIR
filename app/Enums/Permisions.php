<?php

namespace App\Enums;

enum Permisions:int
{
    public const SU = 0;
    public const PROFIL_MANAGE = 1;
    public const POST_MANAGE = 1;
    public const EVENT_MANAGE = 2;
    public const ROLE_MANAGE = 3;
    public const MEMBER_MANAGE = 4;
    public const RESEAU_MANAGE = 5;

    public const GROUP_MANAGE = 6;
    public const VOTE_MANAGE = 7;
    public const FILE_MANAGE = 8;
    public const PHOTO_MANAGE = 9;
    public const SHOP_MANAGE = 10;
    public const SHOP_SELLER = 11;
    public const PAYMENT_MANAGE = 12;
    public const FORM_MANAGE = 13;
    public const INVENTORY_MANAGE = 14;
    public const ACCOUNTING_MANAGE = 14;
    public const ACCOUNTING_READ = 15;
    public const TOURNAMENT_MANAGE = 16;
    public const TOURNAMENT_SUPERVISOR = 17;
    public const DM_READ = 18;
    public const DM_WRITE = 19;
    public const ACCESS_MANAGE = 20;
    public const ENTITE_MANAGE = 21;
}
