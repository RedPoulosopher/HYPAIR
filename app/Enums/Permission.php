<?php

namespace App\Enums;

enum Permission: int
{
    case SUPER_ADMIN = 0;

    // Profil
    case PROFILE_MANAGE = 1;

    // Contenu
    case POST_MANAGE = 2;
    case EVENT_MANAGE = 3;
    case NETWORK_MANAGE = 4;

    // Administration
    case ROLE_MANAGE = 5;
    case MEMBER_MANAGE = 6;
    case GROUP_MANAGE = 7;
    case VOTE_MANAGE = 8;

    // Fichiers et médias
    case FILE_MANAGE = 9;
    case PHOTO_MANAGE = 10;

    // Boutique
    case SHOP_MANAGE = 11;
    case SHOP_SELLER = 12;

    // Paiements
    case PAYMENT_MANAGE = 13;

    // Comptabilité
    case ACCOUNTING_MANAGE = 14;
    case ACCOUNTING_READ = 15;

    // Inventaire
    case INVENTORY_MANAGE = 16;

    // Tournois
    case TOURNAMENT_MANAGE = 17;
    case TOURNAMENT_SUPERVISOR = 18;

    // Messagerie
    case MESSAGE_READ = 19;
    case MESSAGE_WRITE = 20;

    // Accès et entités
    case ACCESS_MANAGE = 21;
    case ENTITY_MANAGE = 22;

    public function label(): string{
    return match($this) {
        self::SUPER_ADMIN => 'Super administrateur',
        self::PROFILE_MANAGE => 'Gestion des profils',
        self::POST_MANAGE => 'Gestion des publications',
        self::EVENT_MANAGE => 'Gestion des événements',
        self::ROLE_MANAGE => 'Gestion des rôles',
        self::MEMBER_MANAGE => 'Gestion des membres',
        self::NETWORK_MANAGE => 'Gestion du réseau',
        self::GROUP_MANAGE => 'Gestion des groupes',
        self::VOTE_MANAGE => 'Gestion des votes',
        self::FILE_MANAGE => 'Gestion des fichiers',
        self::PHOTO_MANAGE => 'Gestion des photos',
        self::SHOP_MANAGE => 'Gestion de la boutique',
        self::SHOP_SELLER => 'Vendeur de la boutique',
        self::PAYMENT_MANAGE => 'Gestion des paiements',
        self::INVENTORY_MANAGE => 'Gestion de l’inventaire',
        self::ACCOUNTING_MANAGE => 'Gestion de la comptabilité',
        self::ACCOUNTING_READ => 'Lecture de la comptabilité',
        self::TOURNAMENT_MANAGE => 'Gestion des tournois',
        self::TOURNAMENT_SUPERVISOR => 'Supervision des tournois',
        self::MESSAGE_READ => 'Lecture des messages',
        self::MESSAGE_WRITE => 'Écriture des messages',
        self::ACCESS_MANAGE => 'Gestion des accès',
        self::ENTITY_MANAGE => 'Gestion des entités',
    };
}
}