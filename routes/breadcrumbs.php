<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
 
Breadcrumbs::for('racine', function (BreadcrumbTrail $trail): void {
    $trail->push('HypAIR', route('racine'));
});

 
Breadcrumbs::for('entite', function (BreadcrumbTrail $trail): void {
    $trail->parent('racine');

    $trail->push('coucou', route('entite', 'air'));
});
