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
def enreg_Chercheur():

    # Ouvrir le fichier JSON en mode lecture
    with open("Chercheur.json", "r", encoding="utf-8") as fichier_json:
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




    #print (data)
    ## OPTIMISATION DES AUTEURS
    i = 0
    for d in data:
        # Liste pour stocker les dictionnaires des auteurs
        formatted_authors = []
        for author in d['auteurs']:
            # Diviser le nom complet en prénom et nom de famille
            split_name = author.split(' ', 1)
            if len(split_name) == 2:
                first_name, last_name = split_name
            else:
                # Handle the case where there is no space in the name
                first_name = split_name[0]
                last_name = ''

            # Créer un dictionnaire pour chaque auteur
            author_dict = {'firstname': first_name, 'lastname': last_name}

            # Ajouter le dictionnaire à la liste
            formatted_authors.append(author_dict)
        data[i]['auteurs'] = formatted_authors
        i += 1

##### PHASE 1 : INSERTION BRUT
    # Exemple de requête SQL pour insérer des données
    query_authors = "INSERT INTO 2025_authors (firstname, lastname, update_date) SELECT %s, %s, CURDATE() WHERE NOT EXISTS (SELECT 1 FROM 2025_authors WHERE firstname = %s AND lastname = %s)"

    query_editors = "INSERT INTO 2025_editors (name) SELECT %s WHERE NOT EXISTS (SELECT 1 FROM 2025_editors WHERE name = %s)"

    query_attachments = "INSERT INTO 2025_attachments (pdf_link, article_link) SELECT %s, %s WHERE NOT EXISTS (SELECT 1 FROM 2025_attachments WHERE pdf_link = %s AND article_link = %s)"

    # Exécution de la requête d'insertion pour chaque jeu de données
    for d in data:
        ## Authors
        # Extraction des données
        for i in range (len(d["auteurs"])):
            firstname, lastname = d["auteurs"][i]["firstname"], d["auteurs"][i]["lastname"]
            # Exécution de la requête
            cursor.execute(query_authors, (firstname, lastname, firstname, lastname))
        ## Editors
        name_editor = d["editeurs"]
        cursor.execute(query_editors, (name_editor,name_editor))
        ## Attachments
        pdf_link, article_link = d["lien_pdf"], d["lien_article"]
        cursor.execute(query_attachments, (pdf_link, article_link, pdf_link, article_link))

    # Valider les changements dans la base de données
    conn.commit()



##### PHASE 2 : MISE EN RELATIONS
    # Exécution de la requête d'insertion pour chaque jeu de données
    for d in data:

        ## Publications
        # Requête SQL
        query_publications =  "INSERT INTO 2025_publications (title, description,type,publication_date, update_date,title_type, pages, id_editor) SELECT %s, %s, %s, %s, CURDATE(), %s, %s,(SELECT e.id FROM 2025_editors AS e WHERE e.name = %s) WHERE NOT EXISTS (SELECT 1 FROM 2025_publications WHERE title = %s)"
        title = d["titre"]
        description = d["description"]
        type = d["type"]
        publication_date = d["date_de_publication"]
        title_type = d["type_titre"]
        pages = d["pages"]
        editor_name = d["editeurs"]
        cursor.execute(query_publications,(title,description, type, publication_date, title_type, pages, editor_name, title ))

    # Valider les changements dans la base de données
    conn.commit()

##### PHASE 3 : INSERTION RELATIONS
    # Exécution de la requête d'insertion pour chaque jeu de données
    for d in data:

        ## Publish
        query_publish =  "INSERT INTO 2025_publish (id_author, id_publication) SELECT (SELECT a.id FROM 2025_authors AS a WHERE a.firstname = %s AND a.lastname = %s), ( SELECT p.id FROM 2025_publications AS p WHERE p.title = %s)  WHERE NOT EXISTS (SELECT 1 FROM 2025_publish WHERE id_author = (SELECT a.id FROM 2025_authors AS a WHERE a.firstname = %s AND a.lastname = %s) AND id_publication = ( SELECT p.id FROM 2025_publications AS p WHERE p.title = %s) )"
        title = d["titre"]
        for i in range (len(d["auteurs"])):
            firstname, lastname = d["auteurs"][i]["firstname"], d["auteurs"][i]["lastname"]
            # Exécution de la requête
            cursor.execute(query_publish, (firstname, lastname, title, firstname, lastname, title))

        ## Links
        query_links =  "INSERT INTO 2025_links (id_publication, id_attachment) SELECT ( SELECT p.id FROM 2025_publications AS p WHERE p.title = %s), ( SELECT at.id FROM 2025_attachments AS at WHERE at.pdf_link = %s AND at.article_link = %s)  WHERE NOT EXISTS (SELECT 1 FROM 2025_links WHERE id_attachment = ( SELECT at.id FROM 2025_attachments AS at WHERE at.pdf_link = %s AND at.article_link = %s) AND id_publication = ( SELECT p.id FROM 2025_publications AS p WHERE p.title = %s) )"

        title = d["titre"]
        pdf_link, article_link = d["lien_pdf"], d["lien_article"]
        # Exécution de la requête
        cursor.execute(query_links, (title, pdf_link, article_link, pdf_link, article_link, title))

    # Valider les changements dans la base de données
    conn.commit()

    # Fermeture du curseur et de la connexion
    cursor.close()
    conn.close()

    return data


