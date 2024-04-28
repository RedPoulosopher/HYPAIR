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
Création d'un utilisateur (l'application qui sera l'application HypAIR). Il faut que vous définissiez son mot de passe. pour ne pas vous embrouiller, vous pouvez mettre le même que juste avant, celui du compte *root* :
```
CREATE USER 'travellist_user'@'%' IDENTIFIED WITH mysql_native_password BY '<motDePasse>';
```
On donne à cette utilisateur toutes les permissions pour interagir avec la base de données :
```
GRANT ALL ON travellist.* TO 'travellist_user'@'%';
```
Vous pouvez à présent sortir de l'invite de commandes *MySQL* en tapant ```exit```.

Vous pouvez vérifier que tout s'est bien passé, en vous connectant sous cet utilisateur avec ```mysql -u hypair_user -p <motDePasse>```, puis en regardant que cet utilisateur voit bien la bonne base de données avec ```SHOW DATABASES;```.

Les tables de cette base de données seront créées plus tard, grâce aux *migrations* de Laravel.

Pendant que vous y êtes, vérifiez quel est le port MySQL :
```
SHOW GLOBAL VARIABLES LIKE 'PORT';
```
Vous verrez un tableau s'afficher dans la console, avec un **numéro de port** noté à droite de ```port```, généralement **3306**. Notez-le quelque part, nous en aurons besoin par la suite.

Pour sortir de l'invite de commandes en tapant ```exit```.

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

## NodeJS

Installation de **nvm** (*Node Version Manager*):
```
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
```
Puis fermez, et rouvrez votre terminal. Vérifiez que **nvm** est bien installé avec :
```
nvm --version
```
Pour le moment, nous utilisons **node 16** pour HypAIR. Tapez donc :
```
nvm install 16
```
Puis vérifiez bien que vous utiliser actuellement node 16 en tapant ```node -v```. Si ce n'est pas le cas, faites ```nvm use 16```.

## Clone d'HypAIR

Clonage du repository (si ce n'est pas encore fait) :
Placez vous dans le dossier où vous voulez installer le projet, et tapez :
```
git clone https://gitlab.etu.imt-nord-europe.fr/associatif/air/site-air.git
```
Vous devrez probablement rentrer vos identifiants d'utilisateur.
Le username est généralement ```prenom.nom```, et votre mot de passe est celui de MyServices.

On se déplace à la racine du projet :
```
cd site-air
```
On duplique le fichier ```.env.exemple``` :
```
cp .env.exemple .env
```
Puis on modifie ce fichier ```.env```:
```
gedit .env
```
Et on complète ou modifie les champs suivants :
```
DB_CONNECTION=mysql
DB_HOST=http://localhost
DB_PORT=<numeroPortMySQL>
DB_DATABASE=hypair_db
DB_USERNAME=hypair_user
DB_PASSWORD=<motDePasseMySQL>
```
Enregistrez puis fermez ce fichier.

Déplacement du projet dans le dossier approprié :
```
cd ..
sudo mv ./site-air /var/www/site-air
```

Installation des dépendances :
```
cd /var/www/site-air
composer install
npm install
```

Vérifiez que tout s'est bien passé en tapant simplement :
```
php artisan
```
Puis compilez les fichiers :
```
npm run dev
```
On génère une clé pour l'application :
```
php artisan key:generate
```
On crée les tables, en lançant les migrations :
```
php artisan migrate:fresh
```
Pour finir, on remplit la base de données grâces aux seeders :
```
php artisan db:seed
```

## Nginx

Installation de Ngnix :
```
sudo apt install nginx
```
On donne au serveur web les droits d'écriture aux dossiers nécessaires :
```
sudo chown -R www-data.www-data /var/www/site-air/storage
sudo chown -R www-data.www-data /var/www/site-air/bootstrap/cache/
```
Créez une configuration pour le site ainsi :
```
sudo gedit /etc/nginx/sites-available/hypair
```
Et copiez le contenu ci-dessous dans ce fichier, puis enregistrez-le :
```
server {
    listen 8080;
    server_name localhost;
    root /var/www/site-air/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
De retour dans le terminal, on créer un lien symbolique :
```
sudo ln -s /etc/nginx/sites-available/hypair /etc/nginx/sites-enabled/hypair
```
Pour être sûr qu'il n'y a pas eu d'erreurs, vous pouvez taper ```sudo nginx -t```.
Pour appliquer les changements, redémarrez le service *nginx* :
```
sudo systemctl reload nginx
```

Maintenant, si tout s'est bien passé, et que ouvrez un navigateur, vous devriez atterrir sur HypAIR en tant l'URL : ```http://localhost```.

## X-Debug
