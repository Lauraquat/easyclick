# EASYCLICK

## Prérequis

Ce projet nécessite les composants suivants :
- php 7.4.3
- mysql 8
- L'utilitaire symfony (https://symfony.com/download)
- npm 7.15 (pour installer npm : https://www.npmjs.com/get-npm)
- composer (pour installer composer : https://getcomposer.org/)
- git

## Téléchargement du projet

1. Clonez le projet : `git clone git@github.com:Lauraquat/easyclick.git`
2. Allez dans le répertoire : `cd easyclick` 

## Installation de Symfony

1. Installez les dépendances php du projet : `composer install`
2. Installez les dépendances css/js du projet : `npm install` 
3. Spécifiez vos variables d'environnement : `cp .env.dist .env.local` puis éditez le fichier `.env.local` pour spécifier votre login et mot de passe mysql
4. Créez la base de données : `bin/console doctrine:database:create && bin/console doctrine:schema:update --force`

## Testez

1. Lancez le projet : `symfony local:server:start --port=8514` (si vous n'avez pas la ligne de commande symfony : https://symfony.com/download)
2. Connectez vous à l'URL d'administration : http://localhost:8514/admin
3. Créez quelques éléments afin de générer le contenu de la base de données (en cliquant sur "add carte")
    Exemple de saisie pour une entrée :

    * Type = Entrées  (les types acceptés sont : Entrées, Plats, Desserts, Boissons)
    * Intitulé = La flamme de l'Océan
    * Description = Rouget - Betterave hibiscus
    * Image = (utiliser par exemple l'url d'une image publique sur internet)
    * Prix = 17
    * Quantité = 15

    **Note : la liaison n'a pas été créée en base de donnée pour les formules et les boissons. Si vous créez un produit de type Boissons, vous ne pourrez pas l'ajouter au panier. Dans le code, ces 2 pages sont statiques.**

4. Afin de passer une commande et pouvoir voir la gestion des stocks, allez sur l'URL : http://localhost:8514/entrees
5. Cliquez sur "Ajouter" pour mettre au panier l'un des produits que vous avez enregistré en base de données
6. Cliquez sur le panier en haut à droite du site pour consulter votre panier
7. Validez le panier ou ajoutez d'autres plats si vous le voulez.