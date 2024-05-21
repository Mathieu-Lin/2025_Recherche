###############################################################################
# Bibliothèque
###############################################################################
import time
import random
from csv import *
import csv
import json
import os
import re

from fake_useragent import UserAgent

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By

from datetime import datetime

#from fastapi import FastAPI

from bs4 import BeautifulSoup as bs

### à corriger
# https://scholar.google.com/scholar?hl=fr&start=50&as_sdt=2005&sciodt=0,5&cites=17198743245772402914&scipsc=
# lien trop sus
###############################################################################
# Configuration anti-bots : User-Agent, Selenium, ...
###############################################################################

def scraping_Citations():

    # Ouvrir le fichier JSON en mode lecture
    with open("Chercheur.json", "r", encoding="utf-8") as fichier_json:
        # Charger le contenu du fichier JSON dans un objet Python
        data = json.load(fichier_json)

    data =     [{"titre": "Hybrid checkpointing for parallel applications in cluster federations","lien_page": "https://scholar.google.fr/citations?view_op=view_citation&hl=fr&user=Eh72wrkAAAAJ&pagesize=100&citation_for_view=Eh72wrkAAAAJ:9yKSN-GCB0IC","lien_citation": "https://scholar.google.com/scholar?oi=bibs&hl=fr&cites=17198743245772402914","auteurs": ["Sébastien Monnet","Christine Morin","Ramamurthy Badrinath"],"date_de_publication": "2004-04-19","type_titre": "IEEE International Symposium on Cluster Computing and the Grid, 2004. CCGrid 2004.","type": "Conférence","editeurs": "IEEE","description": "Cluster federations are attractive for executing applications like large scale code coupling. However faults may appear frequently in such architectures. Thus, checkpointing long-running applications is desirable to avoid to restart them from the beginning in the event of a node failure. To take into account the constraints of a cluster federation architecture, an hybrid checkpointing protocol is proposed. It uses global coordinated checkpointing inside clusters but only quasi-synchronous checkpointing techniques between clusters. The proposed protocol has been evaluated by simulation and fits well for applications that can be divided into modules with lots of communications within modules but few between them.","pages": "773-782","lien_article": "https://ieeexplore.ieee.org/abstract/document/1336712/","lien_pdf": "https://inria.hal.science/inria-00000991/document"}]
    liste_dico = []
    author_links = []  # Initialiser une liste pour stocker les liens des auteurs

    for d in data :

        # Contrer les anti-bots
        # Générer un User-Agent aléatoire
        ua = UserAgent()
        user_agent = ua.random

        # Configuration des options du navigateur Chrome
        chrome_options = Options()
        chrome_options.add_argument(f'user-agent={user_agent}')

        # Si tu ne veux pas afficher chrome
        #chrome_options.add_argument("--headless")  # Exécuter Chrome en mode headless (sans interface graphique)

        ###############################################################################
        # Première Scrapping sur la page principale Google Scholar
        ###############################################################################
        # Charger la page Google Scholar avec Selenium
        driver = webdriver.Chrome(options= chrome_options)
        ## Page principale du citation
        lien_citation_principale = d["lien_citation"]
        driver.get(lien_citation_principale)

        time.sleep(random.uniform(1, 5))
        time.sleep(40)
        # Extraire le HTML de la page
        html = driver.page_source
        # Analyser le HTML avec BeautifulSoup
        soup = bs(html, "html.parser")

        # COmpteur de la page + indice de la liste
        compteur_page = 0
        i = 0

        while soup.find('div', class_='gs_ri') is not None:

            time.sleep(random.uniform(1, 5))
            articles = soup.find_all('div', class_="gs_r gs_or gs_scl")

            for article in articles:
                title2 = article.find('h3')
                if (title2.find('a') != None ):
                    title = title2.find('a').text.strip()
                    liste_dico.append({})
                    liste_dico[i]["titre_cit"] = title
                    liste_dico[i]["titre"] = d["titre"]
                    i = i + 1
                    author_div = article.find('div', class_="gs_a")
                    if author_div:

                        for a_tag in author_div.find_all('a'):  # Itérer sur toutes les balises <a> dans la balise <div>
                            if 'href' in a_tag.attrs:  # Vérifier si l'attribut href existe
                                link = a_tag['href']
                                if link not in author_links:  # Vérifier si le lien n'est pas déjà présent dans la liste
                                    author_links.append("https://scholar.google.fr" +link +"&cstart=0&pagesize=1000000")
            # Incrémenter le compteur de pag
            compteur_page += 10  # La pagination de Google Scholar est par 10

            # Aller à la prochaine page
            lien_citation_mod = lien_citation_principale.replace("oi=bibs", f"start={compteur_page}")
            time.sleep(random.uniform(1, 5))

            # Fermer le navigateur Selenium
            driver.quit()
            time.sleep(random.uniform(1, 5))
            # Contrer les anti-bots

            # Générer un User-Agent aléatoire
            ua = UserAgent()
            user_agent = ua.random

            # Configuration des options du navigateur Chrome
            chrome_options = Options()
            chrome_options.add_argument(f'user-agent={user_agent}')

            # Si tu ne veux pas afficher chrome
            #chrome_options.add_argument("--headless")  # Exécuter Chrome en mode headless (sans interface graphique)

            ###############################################################################
            # Première Scrapping sur la page principale Google Scholar
            ###############################################################################
            # Charger la page Google Scholar avec Selenium
            driver = webdriver.Chrome(options= chrome_options)
            driver.get(lien_citation_mod)
            time.sleep(random.uniform(1, 5))
            time.sleep(40)
            # Extraire le HTML de la nouvelle page
            html = driver.page_source
            # Analyser le HTML avec BeautifulSoup
            soup = bs(html, "html.parser")




        time.sleep(random.uniform(1, 5))

        # Fermer le navigateur Selenium
        driver.quit()
        time.sleep(random.uniform(1, 5))

    with open("Citations.json", "w", encoding="utf-8") as json_file:
        json.dump(liste_dico, json_file, ensure_ascii=False, indent=4)
    with open("Auteurs.json", "w", encoding="utf-8") as json_file:
        json.dump(author_links, json_file, ensure_ascii=False, indent=4)

    return liste_dico, author_links



