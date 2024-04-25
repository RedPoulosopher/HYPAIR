# Installation de l'environnement de développement sous Ubuntu

Il s'agit ici d'installer ce qu'on appelle une pile *LEMP* (Linux, Nginx, MySQL, PHP).
Le but est de mettre en place un environnement de développement pour faire tourner HypAIR en local sous Ubuntu (ici, **22.04**).
Nous ne passerons donc pas par un logiciel qui contient déjà la pile tout faite, comme Wamp sous Windows. Nous ferons la configuration nous-mêmes.

Avant de commencer à installer des packages avec *apt*, comme le veut la tradition, veillez bien à faire un :
```
sudo apt update
```
La légende raconte que si vous oubliez de le faire, vous recevrez des mails d'insultes des ancien.ne.s president.s de l'AIR ;)

## PHP

Installation de PHP et les librairies nécessaires :
```
sudo apt install php8.1-fpm php-mysql
sudo apt install php...
sudo apt install php-cli unzip
```

## MySQL

**MySQL** va vous permettre de mettre en place une base de données en local.

Installation de MySQL :
```
sudo apt install mysql-server
```
On veille à ce que le service soit bien démarré :
```
sudo mysql...
```

On gère les permissions relatives à MySQL :
```
sudo mysql_secure_installation
```
Puis répondez à toutes les questions par ```y```, et tapez ```2``` lorsque l'on vous demande la force du mot de passe exigée, pour plus de sécurité.

Créez vous un mot de passe pour l'utilisateur *root* **que vous noterez quelque part** pour ne pas l'oublier :
```
...
```

Création de la base de données :
```
CREATE DATABASE hypair_db;
```
Création d'un utilisateur (l'application qui sera l'application HypAIR) :
```
CREATE USER 'travellist_user'@'%' IDENTIFIED WITH mysql_native_password BY 'password';
```
On donne à cette utilisateur toutes les permissions pour interagir avec la base de données :
```
GRANT ALL ON travellist.* TO 'travellist_user'@'%';
```
Vous pouvez à présent sortir de l'invite de commandes *MySQL* en tapant ```exit```.

Vous pouvez vérifier que tout s'est bien passé, en vous connectant sous cet utilisateur avec ```mysql -u hypair_user -p <motDePassePourL_utilisateurHypair>```, puis en regardant que cet utilisateur voit bien la bonne base de données avec ```SHOW DATABASES;```.

Les tables de cette base de données seront créées plus tard, grâce aux *migrations* de Laravel.

### MySQL Workbench

**MySQL Workbench** est un logiciel complémentaire qui offre une interface graphique pour la gestion de base de données, de la même manière que *PhpMyAdmin*.

Cela vous facilitera la tâches, mais ce n'est pas une étape obligatoire. Si vous souhaitez vous passer d'une Interface graphique, vous devrez uniquement passer par des requêtes SQL pour la gestion de BDD.

Installation **sous Ubuntu (pas Pop OS)** :
```
sudo apt install mysql-workbench
```
Sous Pop OS, il faut passer par *snap*. Si *snap* n'est pas déjà installé : ```sudo apt install snapd```. Puis :
```
sudo snap install mysql-workbench
```

Il faut ensuite créer une liaison entre *MySQL Workbench* et la base de données. Ici, on va créer une laision qui nous permettra de nous placer en tant que ```hypair_user```, c'est à dire l'application elle-même :
... 


## Composer

Téléchargement de l'installeur de **composer** :
```
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
```

### Vérification de l'installeur
Pour plus de sûreté, il vaut mieux vérifier que l'installeur n'est pas corrompu :
```
HASH=`curl -sS https://composer.github.io/installer.sig`
```
```
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```
Si vous obtenez le message ```Installer verified```, vous pouvez passer à la suite. Sinon, vérifiez que vous avez bien téléchargé le bon script.

Installation de **composer** sur le système global :
```
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```
Pour vérifier que l'installation s'est bien passée, tapez la commande ```composer```, et admirez la jolie écriture.

## Clone d'HypAIR
- git clone
- cd
- composer install
- php artisan pour check


## Nginx

Installation de Ngnix :
```
sudo apt install nginx
```
