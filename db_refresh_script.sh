#!/bin/bash

# Charger les paramètres depuis le fichier .env
if [ -f .env ]; then
    export $(grep -v '^#' .env | xargs)
else
    echo "Erreur: Le fichier .env est introuvable."
    exit 1
fi

echo "Suppression de l'ancienne base de données MySQL..."
mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "DROP DATABASE IF EXISTS $DB_DATABASE;"

echo "Création de la base de données MySQL..."
if ! mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;" ; then
    echo "Erreur: Impossible de créer la base de données."
    exit 1
fi
# Importer le fichier SQL
if [ -f db_sql/ntierprojet_database.sql ]; then
    echo "Importation de la base de données..."
    mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < db_sql/ntierprojet_database.sql
    echo "La base de données a été importée avec succès."
else
    echo "Erreur: Le fichier SQL (db_sql/ntierprojet_database.sql) est introuvable."
    exit 1
fi

