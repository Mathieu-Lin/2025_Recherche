###############################################################################
# Bibliothèque
###############################################################################

from sqlalchemy import create_engine, Table, Column, Integer, String, MetaData
from sqlalchemy.orm import sessionmaker
import mysql.connector

import json

###############################################################################
# Programmes
###############################################################################
# Ouvrir le fichier JSON en mode lecture

def enreg_Citations():

    # Ouvrir le fichier JSON en mode lecture
    with open("Citations.json", "r", encoding="utf-8") as fichier_json:
        # Charger le contenu du fichier JSON dans un objet Python
        data = json.load(fichier_json)


    # Informations de connexion à la base de données
    config = {
        'user': 'root',
        'password': '',
        'host': 'localhost',
        'database': 'test'
    }

    # Connexion à la base de données
    conn = mysql.connector.connect(**config)

    # Encodage UTF8 pour les échanges avec la BD
    cursor = conn.cursor()
    cursor.execute("SET NAMES UTF8")

    # Exécution de la requête d'insertion pour chaque jeu de données
    for d in data:
        sql_query = "INSERT INTO 2025_quotes (id_publication, id_quote) SELECT p1.id AS id_publication,p2.id AS id_quote FROM (SELECT id FROM 2025_publications WHERE title = %s) p1, (SELECT id FROM 2025_publications WHERE title = %s) p2 WHERE NOT EXISTS (SELECT 1 FROM 2025_quotes q WHERE q.id_publication = (SELECT p.id FROM 2025_publications p WHERE p.title = %s) AND q.id_quote = (SELECT p.id FROM 2025_publications p WHERE p.title = %s));"

        titre, titre_cit = d["titre"], d["titre_cit"]
        # Exécution de la requête
        cursor.execute(sql_query, (titre, titre_cit, titre, titre_cit))

    # Valider les changements dans la base de données
    conn.commit()

    # Fermeture du curseur et de la connexion
    cursor.close()
    conn.close()

    return

