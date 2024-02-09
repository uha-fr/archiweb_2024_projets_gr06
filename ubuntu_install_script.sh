#!/bin/bash

    # Installation de PHP
    # Installation de Mysql et php-mysql
    # Installation de Composer, puis des packages du projet via Composer
    # Mise en place de la base de données grâce au fichier sql du projet

echo "----------------------------------------------"
echo "|    Installation et configuration du projet    |"
echo "|    - Installation de PHP et Composer          |"
echo "|    - Configuration de la base de données      |"
echo "|    - Démarrage du serveur PHP intégré         |"
echo "----------------------------------------------"
echo
# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo "PHP n'est pas installé. Installation en cours..."
    sudo apt-get update
    sudo apt-get install php

    echo "PHP a été installé avec succès."
else
    echo "PHP est déjà installé."
fi

# Vérifier si Composer est installé
if ! command -v composer &> /dev/null; then
    echo "Composer n'est pas installé. Installation en cours..."
    # Installation de Composer
    EXPECTED_CHECKSUM="$(curl -s https://composer.github.io/installer.sig)"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
    
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
    then
        >&2 echo 'ERREUR : Le fichier de Composer semble être corrompu'
        rm composer-setup.php
        exit 1
    fi
    
    php composer-setup.php --quiet
    RESULT=$?
    rm composer-setup.php composer-setup.sig
    if [ $RESULT -ne 0 ]; then
        echo "Erreur lors de l'installation de Composer."
        exit 1
    fi
    mv composer.phar /usr/local/bin/composer
    echo "Composer a été installé avec succès."
else
    echo "Composer est déjà installé."
fi

# Charger les paramètres depuis le fichier .env
if [ -f .env ]; then
    export $(grep -v '^#' .env | xargs)
else
    echo "Erreur: Le fichier .env est introuvable."
    exit 1
fi

# Vérification de MySQL
if ! command -v mysql &> /dev/null; then
    echo "MySQL n'est pas installé. Installation en cours..."
    
    # Installation de MySQL (utilisation d'apt-get pour Ubuntu)
    sudo apt-get update
    sudo apt-get install mysql-server -y

    # Vérification de l'installation
    if ! command -v mysql &> /dev/null; then
        >&2 echo "ERREUR : L'installation de MySQL a échoué."
        exit 1
    fi

    echo "MySQL a été installé avec succès."
else
    echo "MySQL est déjà installé."
fi

# installation de php-mysql pour pdo
sudo apt-get install php-mysql

echo "Création de la base de données MySQL..."
# Créer la base de données
if ! mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;" ; then
    echo "Erreur: Impossible de créer la base de données."
    exit 1
fi
# Importer le fichier SQL
if [ -f db_sql/ntierprojet_database.sql ]; then
    echo "Importation de la base de données..."
    mysql -u"$DB_USERNAME" -p "$DB_PASSWORD" "$DB_DATABASE" < db_sql/ntierprojet_database.sql
    echo "La base de données a été importée avec succès."
else
    echo "Erreur: Le fichier SQL (db_sql/ntierprojet_database.sql) est introuvable."
    exit 1
fi

composer install