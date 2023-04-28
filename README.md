# Le Projet HypAIR

HypAIR est un site qui se veut être un complément (voir un indispensable à l'avenir) à la vie associative en ajoutant des fonctionnalités et des services qui serviront et amélioreront la vie étudiante (calendrier personnel, événement) et aussi la pérennité des comités et des associations en centralisant les informations et en les sauvegardant pour les années à venir (documentations, projets etc.). Nous voulons être présents sur tous les campus et disponibles sur ordinateur et sur mobile.

Le projet HypAIR en est encore à ses débuts. Cela veut donc dire que le site est encore loin d'être fini. Il y a encore beaucoup d'améliorations à apporter et de fonctionnalités que nous avons en tête. Donc n'hésitez pas à nous faire des retours sur votre ressenti et sur les nouveautés que vous aimeriez voir ;)

N'hésitez pas à jeter un coup d'oeil au site : https://hypair.imt-ne.fr/

Si vous voulez nous aider à développer notre site tout au long de l'année vous pouvez nous le faire savoir et rejoindre nos réseaux, depuis la [page de notre comité sur le site HypAIR](https://hypair.imt-ne.fr/air).

## Responsables du projet en 2023-2024
- Arthur Mata, Président de l'AIR (mandat 2023-2024)
- Antoine Joncheray, Membre de l'AIR

## Hébergement du site
HypAIR est hébergé sur un serveur Kimsufi chez **OVH**, ce qui lui permet d'être accessible depuis n'importe quel réseau.

## Technologies utilisées

- Concernant le *backend*, HypAIR est développé avec le framework PHP **Laravel** (version 9). La documentation est disponible sur le [site officiel de Laravel](https://laravel.com/docs/9.x).
- Le *frontend* est fait à l'aide de **Blade**, fourni avec Laravel. Voir la documentation de Blade [ici](https://laravel.com/docs/9.x/frontend#php-and-blade).
- HypAIR fait également appel à **CerbAIR**, plateforme d'*authentification* s'appuyant sur la base de données de la DISI.

# Prérequis
Pour faire fonctionner le site sur votre propre ordinateur, il vous faut au préalable :
- Un IDE (par exemple VS Code ou PHP Storm)
- PHP (version 8.0 au minimum)
- Composer
- NodeJS
- Une base de données MySQL
- Git
- Un serveur web (comme Nginx) avec un VHost paramétré qui a comme racine le dossier `site-air/public`

## Installation des prérequis sous Windows
Cette section explique de manière détaillée comment se munir de tous les éléments cités précédemment. Plusieurs solutions sont par ailleurs possibles. En voici une, utilisant une **Pile WAMP** (Windows - Apache - MySQL - PHP), en partant de zéro.

### • VS Code
**VS Code** est un éditeur de texte, qui peut être transformé en IDE via des extensions permettant de compiler des fichiers sources.
Le logiciel peut être télécharger sur le [site officiel](https://code.visualstudio.com/).

Une fois installé, depuis l'interface de VS Code, vous pouvez télécharger l'extension suivante :
- GitLens : **INDISPENSABLE** pour utiliser Git avec l'interface de VS Code


Les extensions suivantes ne sont pas nécessaires, mais peuvent faciliter la vite :
- PHP (All-in-One PHP support) : fournit des aides pour coder en PHP
- Laravel Snippets : fournit des raccourcis de code liés à la syntaxe de Laravel
- JavaScript (ES6) code snippets : permet de développer en javascript plus facilement
- Prettier - Code formatter : pour l'esthétique du code
- Color Highlight : pour visualiser les couleurs *RGB* directement dans votre code

### • WampServer
**WampServer** est un logiciel gratuit fournissant une bonne partie des outils nécessaires pour faire fonctionner un projet Laravel sous Windows.

En vous rendant sur le [site officiel](https://www.wampserver.com/), vous pouvez télécharger la dernière version pour *Windows 64 bits*, puis l'installer. Si vous ne voulez pas remplir le formulaire qui apparaît sur le site, il y a un petit bouton *passer au téléchargement direct*.

Lors de l'installation, vous pouvez laisser le chemin par défaut (à la racine de votre disque). Vérifiez qu'il y a bien PHP 8.1 dans les paramètres d'installations. Vous pouvez laisser tout le reste par défaut.

Une fois l'installation terminée, si ce n'est pas déjà fait, lancez WampServer 64. Ensuite, il faut désactiver MySQL, pour seulement laisser MariaDB (qui est un équivalent). Pour cela, sur l'icône verte de Wamp dans votre barre des tâches, faites clic droit > `paramètres wamp` > décocher `autoriser MySQL`.

Pour accéder à votre base de données (comme en cours de SGBD), faites un clic gauche sur l'icône, puis lancez **PhpMyAdmin**. Puis connectez-vous avec le login `root` et sans mot de passe.

### • PHP
PHP est déjà fourni avec WampServer, et contient toutes les extensions PHP nécessaires. Cependant, il faut modifier vos variables d'environnement pour que la commande `php` soit reconnue dans votre terminal.

Pour cela, via l'explorateur de fichiers, allez dans votre dossier `wamp64` (celui indiqué lors de l'installation). Dans le dossier `wamp64/bin/php`, vous trouverez plusieurs versions de PHP. Ouvrez un dossier dont la version de php commence par 8.1, par exemple `php8.1.0`. Copiez le chemin de ce dossier en cliquant dans la barre du haut.

Ensuite, tapez "variables" dans votre barre de recherche, et cliquez sur `Modifier les variables d'environnement système`. Puis cliquez sur `variables d'environnement` en bas de la fenêtre. Cliquez sur `Path` puis `Modifier`. Faites `Nouveau`, et collez le chemin que vous avez copié précédemment. Si jamais un chemin similaire est présent dans cette liste, et qu'il mène vers une version antérieure de PHP, supprimez-le. Vous pouvez ensuite valider et fermer toutes ces fenêtres.

Pour vérifier que PHP ets recconu, ouvrez un terminal de commande, et tapez `php -v`. S'il n'y a pas d'erreur, cela a fonctionné :)

Sinon, le fait de redémarrer l'ordinateur suffit parfois à régler le problème...

### • Composer
Rendez-vous sur le [site de Composer](https://getcomposer.org/download/), et cliquez sur `Composer-Setup.exe` pour télécharger **Composer**.
Lancez l'installation, et veillez à ce que la version que vous avez dans votre Path soit bien renseignée, pour que Composer puisse l'utiliser.

Pour vérifier le bon fonctionnement de Composer, ouvrez un terminal et tapez `composer`.

### • NodeJS
HypAIR ne semble pas aprécier les versions récentes de NodeJS. Il faut donc installer la *version 16*.

Pour cela, rendez-vous sur la [page GitHub de nvm](https://github.com/coreybutler/nvm-windows/releases) (qui est un gestionnaire de versions de Node). Télécharger le fichier `nvm-setup.exe`, un peu plus bas sur la page. Terminez l'installation.

Dans un terminal, tapez `nvm install 16`. Une fois l'installation de Node terminée, tapez `nvm use 16`pour utiliser cette version de manière permanente.

### • Git
Rendez-vous sur le [site de Git](https://git-scm.com/) et téléchargez-le. Laissez tous les paramètres par défaut lors de l'installation.

### Clonage du repository
blabla

# Fonctionnalités futures
blabla


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
