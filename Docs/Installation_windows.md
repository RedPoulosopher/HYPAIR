# Installation sous Windows

Nous allons voir ici comment se configurer un environnement de développement sur Windows.

Nous allons mettre en place une **pile WAMP** (Windows - Apache - MySQL - PHP). Pour nous faciliter la tâche, nous allons passer par WampServer64, qui nous fournira la plupart des outils dont nous aurons besoin.

## WampServer
**WampServer** est un logiciel gratuit fournissant une bonne partie des outils nécessaires pour faire fonctionner un projet Laravel sous Windows.

En vous rendant sur le [site officiel](https://www.wampserver.com/), vous pouvez télécharger la dernière version pour *Windows 64 bits*, puis l'installer. Si vous ne voulez pas remplir le formulaire qui apparaît sur le site, il y a un petit bouton *passer au téléchargement direct*.

Lors de l'installation, vous pouvez laisser le chemin par défaut (à la racine de votre disque). Vérifiez qu'il y a bien PHP 8.1 dans les paramètres d'installations. Vous pouvez laisser tout le reste par défaut.

Une fois l'installation terminée, si ce n'est pas déjà fait, lancez WampServer 64. Ensuite, il faut désactiver MySQL, pour seulement laisser MariaDB (qui est un équivalent). Pour cela, sur l'icône verte de Wamp dans votre barre des tâches, faites clic droit > `paramètres wamp` > décocher `autoriser MySQL`.

Pour accéder à votre base de données (comme en cours de SGBD), faites un clic gauche sur l'icône, puis lancez **PhpMyAdmin**. Puis connectez-vous avec le login `root` et sans mot de passe.

## PHP
PHP est déjà fourni avec WampServer, et contient toutes les extensions PHP nécessaires. Cependant, il faut modifier vos variables d'environnement pour que la commande `php` soit reconnue dans votre terminal.

Pour cela, via l'explorateur de fichiers, allez dans votre dossier `wamp64` (celui indiqué lors de l'installation). Dans le dossier `wamp64/bin/php`, vous trouverez plusieurs versions de PHP. Ouvrez un dossier dont la version de php commence par 8.1, par exemple `php8.1.0`. Copiez le chemin de ce dossier en cliquant dans la barre du haut.

Ensuite, tapez "variables" dans votre barre de recherche, et cliquez sur `Modifier les variables d'environnement système`. Puis cliquez sur `variables d'environnement` en bas de la fenêtre. Cliquez sur `Path` puis `Modifier`. Faites `Nouveau`, et collez le chemin que vous avez copié précédemment. Si jamais un chemin similaire est présent dans cette liste, et qu'il mène vers une version antérieure de PHP, supprimez-le. Vous pouvez ensuite valider et fermer toutes ces fenêtres.

Pour vérifier que PHP est reconnu, ouvrez un terminal de commande, et tapez `php -v`. S'il n'y a pas d'erreur, cela a fonctionné :)

Sinon, le fait de redémarrer l'ordinateur suffit parfois à régler le problème...

## Composer
Rendez-vous sur le [site de Composer](https://getcomposer.org/download/), et cliquez sur `Composer-Setup.exe` pour télécharger **Composer**.
Lancez l'installation, et veillez à ce que la version que vous avez dans votre Path soit bien renseignée, pour que Composer puisse l'utiliser.

Pour vérifier le bon fonctionnement de Composer, ouvrez un terminal et tapez `composer`.

## NodeJS
HypAIR ne semble pas aprécier les versions récentes de NodeJS. Il faut donc installer la *version 16*.

Pour cela, rendez-vous sur la [page GitHub de nvm](https://github.com/coreybutler/nvm-windows/releases) (qui est un gestionnaire de versions de Node). Télécharger le fichier `nvm-setup.exe`, un peu plus bas sur la page. Terminez l'installation.

Dans un terminal, tapez `nvm install 16`. Une fois l'installation de Node terminée, tapez `nvm use 16`pour utiliser cette version de manière permanente.

## Git
Rendez-vous sur le [site de Git](https://git-scm.com/) et téléchargez-le. Laissez tous les paramètres par défaut lors de l'installation.

## Clonage du repository

Cliquez sur le bouton `clone`sur GitLab (en haut à droite), et copiez le lien en-dessous de `clone with https`. Puis, ouvrez **Git Bash** à l'endroit où voulez importer le projet sur votre ordinateur, et tapez `git clone <lien>`, en remplissant **<lien>** par ce que vous venez de copier.
Vous n'avez plus qu'à ouvrir le projet sur votre IDE, taper `git pull` dans le terminal et vérifier que votre *branche main*  est à jour :)

## Mise en place
Dupliquez le fichier `.env.example`, et appelez-le `.env`.

Modifiez les lignes suivantes (si nécessaire)
- `APP_ENV=local`
- `APP_DEBUG=true`
- `DB_HOST=localhost`
- `DB_PORT=3307` : le port de MySQL est visible en ouvrant PhpMyAdmin (il est possible qu'il soit different de 3307)
- `DB_DATABASE=HypAIR` : le nom de votre base de données 
- `DB_USERNAME=root` : l'identifiant pour vous connecter à PhpMyAdmin

Ensuite, tapez les commandes suivantes :
- `npm install`
- `composer install`
- `php artisan key:generate`
- `php artisan storage:link`
- `php artisan migrate:fresh`
- `php artisan db:seed`

Pour finir, et **ce qui suit est valable chaque fois que vous voudrez faire fonctionner HypAIR sur votre machine**, tapez :
- `npm run dev` pour compiler les fichiers liés aux dépendances de Node (notamment les feuilles de style *sass*)
