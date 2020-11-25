# EASYCLICK

## Téléchargement du projet

1. Clonez le projet : `git clone git@github.com:Lauraquat/easyclick.git`
2. Allez dans le répertoire : `cd easyclick` 

## Installation de Symfony

1. Installez les dépendances du projet : `composer install` (si vous n'avez pas composer : https://getcomposer.org/)
2. Spécifiez vos variables d'environnement : `cp .env.dist .env.local` puis éditez le fichier `.env.local` pour spécifier votre login et mot de passe mysql
3. Créez la base de données : `bin/console doctrine:database:create && bin/console doctrine:schema:update --force`

## Testez

1. Lancez le projet : `symfony local:server:start --port=8514` (si vous n'avez pas la ligne de commande symfony : https://symfony.com/download)
