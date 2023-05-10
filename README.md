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

Une fois installé, depuis l'interface de VS Code, vous pouvez télécharger les extensions suivantes, qui ne sont pas nécessaires, mais peuvent faciliter la vie :
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

Pour accéder à votre base de données (comme en cours de SGBD), faites un clic gauche sur l'icône, puis lancez **PhpMyAdmin**. Puis connectez-vous avec le login `root` et sans mot de passe. Enfin, créez une base de données nommée `HypAIR`.

### • PHP
PHP est déjà fourni avec WampServer, et contient toutes les extensions PHP nécessaires. Cependant, il faut modifier vos variables d'environnement pour que la commande `php` soit reconnue dans votre terminal.

Pour cela, via l'explorateur de fichiers, allez dans votre dossier `wamp64` (celui indiqué lors de l'installation). Dans le dossier `wamp64/bin/php`, vous trouverez plusieurs versions de PHP. Ouvrez un dossier dont la version de php commence par 8.1, par exemple `php8.1.0`. Copiez le chemin de ce dossier en cliquant dans la barre du haut.

Ensuite, tapez "variables" dans votre barre de recherche, et cliquez sur `Modifier les variables d'environnement système`. Puis cliquez sur `variables d'environnement` en bas de la fenêtre. Cliquez sur `Path` puis `Modifier`. Faites `Nouveau`, et collez le chemin que vous avez copié précédemment. Si jamais un chemin similaire est présent dans cette liste, et qu'il mène vers une version antérieure de PHP, supprimez-le. Vous pouvez ensuite valider et fermer toutes ces fenêtres.

Pour vérifier que PHP est reconnu, ouvrez un terminal de commande, et tapez `php -v`. S'il n'y a pas d'erreur, cela a fonctionné :)

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

## Clonage du repository

Cliquez sur le bouton `clone`sur GitLab (en haut à droite), et copiez le lien en-dessous de `clone with https`. Puis, ouvrez **Git Bash** à l'endroit où voulez importer le projet sur votre ordinateur, et tapez `git clone <lien>`, en remplissant **<lien>** par ce que vous venez de copier.
Vous n'avez plus qu'à ouvrir le projet sur votre IDE, taper `git pull` dans le terminal et vérifier que votre *branche main*  est à jour :)

## Mise en place
Dupliquez le fichier `.env.example`, et appelez-le `.env`.

Modifiez les lignes suivantes (si nécessaire)
- `APP_ENV=local`
- `APP_DEBUG=true`
- `APP_HOST=localhost`
- `DB_PORT=3307` : le port de MySQL est visible en ouvrant PhpMyAdmin (il est possible qu'il soit different de 3307)
- `DB_DATABASE=HypAIR` : le nom de votre base de données 
- `DB_USERNAME=root` : l'identifiant pour vous connecter à PhpMyAdmin

Ensuite, tpez les commandes suivantes :
- `npm install`
- `composer install`
- `php artisan key:generate`
- `php artisan migrate:fresh`
- `php artisan db:seed`

Pour finir, et **ce qui suit est valable chaque fois que vous voudrez faire fonctionner HypAIR sur votre machine**, tapez :
- `npm run dev` pour compiler les fichiers liés aux dépendances de Node (notamment les feuilles de style *sass*)

**OU**
- `npm run watch` pour effectuer l'action qui précède à chaque fois que vous sauvegardez un fichier (Ctrl+S)

**PUIS**
- `php artisan serve` pour lancer le serveur local

Vous pouvez alors faire `Ctrl + clic gauche` sur l'URL qui s'affiche dans la console pour vous rendre sur HypAIR !!!

# Fonctionnalités futures
- Système d'actualités 
- Page d'accueil qui s'adapte à l'utilisateur 
- Conversion en PWA
