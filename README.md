================ Projet de système de gestion de bases de données ================

Ce dossier contient la réalisation du système de gestion d'une flotte de vélo.

Dans le dossier base/ se trouvent les différents fichier de création, peuplement et suppression du SGBD, en MySQL.

Le dossier interface/ contient tous les fichier relatifs à la mise en place de l'interface web.


================= Mise en place du SGBD ===============

Pour mettre en place le SGBD, vous pouvez utiliser la démarche de votre choix. Voici celle que nous avons utilisé:

1. installer XAMPP puis net-tools :

    - Se rendre à l'url suivant : https://www.apachefriends.org/index.html, télécharger l'installateur XAMPP sur la bonne distribution puis l'éxécuter.

    - Installer net-tools:
        $~> sudo apt-get install net-tools


2. Lancer XAMPP

    $~> sudo /opt/lampp/lampp start

3. Mettre en place de SGBD 

    - Se rendre sur le navigateur à l'adresse https://localhost
    - Se rendre sur phpMyadmin (en haut a droit)
    - Créer une nouvelle base de données que l'ont nomera basevelo
    - Importer les ficher sql de création et de peuplement

Le SGBD est maintenant créé, on peut intéragir avec sepuis phpMyAdmin.

============ Mise en place de l'interface =============

Une fois encore, plusieurs façons permettent de faire tourner l'interface, voici celle que nous avons choisi:


0. Avoir installé et lancé XAMPP ainsi que lancé le SGBD, comme décrit dans la section précédente.

1. Permettre au serveur d'avoir accès au repertoir courant (A faire une seule fois):

    $~> sudo ln -s '~/Path/to/current/directory' /opt/lampp

2. Accéder à l'interface

    Se rendre sur le navigateur à l'adresse: https://localhost//projet/src/interface/index.php

La navigation sur l'interface est maintenant possible!


    