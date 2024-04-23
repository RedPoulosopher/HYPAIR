# Installation de l'environnement de développement sous Ubuntu

Il s'agit ici d'installer ce qu'on appelle une pile *LEMP* (Linux, Nginx, MySQL, PHP).
Le but est de mettre en place un environnement de développement pour faire tourner HypAIR en local sous Ubuntu.
Nous ne passerons donc pas par un logiciel qui contient déjà la pile tout faite, comme Wamp sous Windows. Nous ferons la configuration nous-mêmes.

Avant de commencer à installer des packages avec *apt*, comme le veut la tradition, veillez bien à faire un :
```
sudo apt update
```
La légende raconte que si vous oubliez de le faire, vous recevrez des mails d'insultes des ancien.ne.s president.s de l'AIR ;)

## PHP

Installation de PHP et les librairies nécessaires :
```
sudo apt install php...
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
sudo mysql...
```
... (répondre aux questions)

### MySQL Workbench

**MySQL Workbench** est un logiciel complémentaire qui offre une interface graphique pour la gestion de base de données, de la même manière que *PhpMyAdmin*.

Cela vous facilitera la tâches, mais ce n'est pas une étape obligatoire. Si vous souhaitez vous passer d'une Interface graphique, vous devrez uniquement passer par des requêtes SQL pour la gestion de BDD.

Installation **sous Ubuntu (pas Pop OS)** :
```
sudo apt install mysql-workbench
```

## Laravel

## Nginx
