# Installation de l'environnement de développement sous Ubuntu

Il s'agit ici d'installer ce qu'on appelle une pile *LEMP* (Linux, Nginx, MySQL, PHP).
Le but est de mettre en place un environnement de développement pour faire tourner HypAIR en local sous Ubuntu (ici, **22.04**).
Nous ne passerons donc pas par un logiciel qui contient déjà la pile tout faite, comme Wamp sous Windows. Nous ferons la configuration nous-mêmes.

Un des avantages est qu'aussitôt l'ordinateur allumé, le site est déjà disponible, car le serveur web tourne en permanence. Pas de besoin par exemple de ```php artisan serve``` ou de lancer un logiciel tel que *WampServer*.

Avant de commencer à installer des packages avec *apt*, comme le veut la tradition, veillez bien à faire un :
```
sudo apt update
```
La légende raconte que si vous oubliez de le faire, vous recevrez des mails d'insultes des ancien.ne.s president.s de l'AIR ;)

## PHP

Installation de PHP et les librairies nécessaires :
```
sudo apt install php8.1-fpm php-mysql
sudo apt install php-mbstring php-xml php-bcmath php-curl
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
sudo systemctl start mysql.service
```

On gère les permissions relatives à MySQL :
```
sudo mysql_secure_installation
```
Puis répondez à toutes les questions par ```y```, et tapez ```2``` lorsque l'on vous demande la force du mot de passe exigée, pour plus de sécurité.

**N.A.** : Les paragraphes suivants suivants, je ne suis pas sûr. Testez en fonction des erreurs que vous avez chez vous ^^

Pour entrer dans l'invite de commandes MySQL, tapez `sudo mysql`.

Créez-vous un mot de passe pour l'utilisateur *root* **que vous noterez quelque part** pour ne pas l'oublier, dans l'invite de commande de MySQL :
```
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '<motDePasse>';
```
Si vous souhaitez vous passer de ce mot de passe, et simplement vous connecter en passant par `sudo mysql`, tapez ceci :
```
ALTER USER 'root'@'localhost' IDENTIFIED WITH auth_socket;
```

Création de la base de données :
```
CREATE DATABASE hypair_db;
```
Création d'un utilisateur (l'application qui sera l'application HypAIR). Il faut que vous définissiez son mot de passe. pour ne pas vous embrouiller, vous pouvez mettre le même que juste avant, celui du compte *root* :
```
CREATE USER 'hypair_user'@'%' IDENTIFIED WITH mysql_native_password BY '<motDePasse>';
```
On donne à cette utilisateur toutes les permissions pour interagir avec la base de données :
```
GRANT ALL ON hypair_db.* TO 'hypair_user'@'%';
```
Vous pouvez à présent sortir de l'invite de commandes *MySQL* en tapant ```exit```.

Vous pouvez vérifier que tout s'est bien passé, en vous connectant sous cet utilisateur avec ```mysql -u hypair_user -p```, puis en regardant que cet utilisateur voit bien la bonne base de données avec ```SHOW DATABASES;```.

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
sudo snap install mysql-workbench-community
```

Il faut ensuite créer une liaison entre *MySQL Workbench* et la base de données. Ici, on va créer une laision qui nous permettra de nous placer en tant que ```hypair_user```, c'est à dire l'application elle-même :
- Créer une nouvelle connexion
- Entrez le *username* : `hypair_user`
- Entrez le mot de passe que vous avez défini précédemment pour cet utilisateur de MySQL.
- Donnez un nom à cette liaison (par exemple *hypair*)
- Et c'est tipar !


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

Si vous n'avez pas encore de dossier `www`, creez-le :
```
sudo mkdir /var/www
```

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

**XDebug** est un debugger pour PHP. Cette étape est facultative, mais vous facilitera le développement. 

Pour l'utiliser, il faut l'ajouter à la configuration du PHP utilisé, ajouter une extension à votre navigateur, et configurer votre IDE.

Ici, l'exemple se fera avec l'IDE **PhpStorm**, et Firefox.

### Configuration de PHP

Téléchargez XDebug :
```
sudo apt install php8.1-xdebug
```

Ouvrez le fichier de configuration de **php** :
```
sudo gedit /etc/php/8.1/cli/conf.d/20-xdebug.ini
```

Ajoutez les lignes suivantes à la suite dans ce fichier :
```
xdebug.mode=debug
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
```

Sauvegardez le fichier, puis fermez, et redémarrez PHP :
```
sudo service php8.1-fpm restart
```

### Extension du navigateur

Trouvez une extension que vous pouvez utiliser avec votre navigateur préféré. Vous pouvez les voir dans le tableau récapitulatif sur [cette page](https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html)

Ici, pour **Firefox**, nous allons utiliser[XDebug helper](https://addons.mozilla.org/en-US/firefox/addon/xdebug-helper-for-firefox/?utm_source=addons.mozilla.org&utm_medium=referral&utm_content=search)

Téléchargez l'extension, et lorsque vous êtes sur la page d'HypAIR, cliquez sur l'insecte à droite de la barre de recherche, et cliquer sur **Debug**. Lorsque l'insecte est colorié, le debugger est activé.

Vous aurez peut-être besoin de relancer votre navigateur et rouvrir la page d'HypAIR, pour que l'insecte s'affiche.

### Configuration de l'IDE

Il faut lier le numéro de port utilisé par XDebug renseigné plus haut dans la configuration de PHP, et celui de la configuration de débuggage de votre IDE. Ici, ce sera fait avec **PhpStorm**.

Allez dans `Settings` > `PHP`, et veillez à ce que le chemin de PHP soit bien celui que vous voulez utilisez pour le projet (celui où vous avez installé **XDebug**).

En allant dans `Settings` > `PHP` > `Debug`, vous pouvez vérifier que l'IDE est bien lié au port de **XDebug** (9003 ici).

Fermez les paramètres, et appuyez sur le bouton **Start listening for PHP Debug connections**.

Mettez des breakpoints à des endroits pertinents de fichiers **.php**, en cliquant sur le numéro d'une ligne de code. Par exemple, pour que le programme fasse une fasse lors du chargement de la page d'accueil d'HypAIR, vous mettre un breakpoint à la ligne `$now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');` (ligne 34) du fichier `app/Http/Controllers/PostController.php`.

Puis rechargez la page sur votre navigateur. Si vous êtes redirigé vers une pop-up de votre IDE, cliquez sur **Accepter**.
Si tout s'est bien passé, l'exécution devrait s'être arrêtée au niveau de la ligne comportant le breakpoint, en attendant vos ordres. C'est pas magnifique ???
